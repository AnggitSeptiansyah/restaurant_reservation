<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }

    /** @test */
    public function admin_can_view_menus_index()
    {
        Menu::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.menus.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.menus.index');
        $response->assertViewHas('menus');
        $this->assertCount(3, $response->viewData('menus'));
    }

    /** @test */
    public function admin_can_view_create_menu_form()
    {
        Category::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.menus.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.menus.create');
        $response->assertViewHas('categories');
        $this->assertCount(2, $response->viewData('categories'));
    }

    /** @test */
    public function admin_can_store_new_menu_with_categories()
    {
        Storage::fake();

        $categories = Category::factory()->count(2)->create();
        $file = UploadedFile::fake()->image('menu.jpg');

        $data = [
            'name' => 'Nasi Goreng',
            'price' => 35000,
            'description' => 'Nasi goreng spesial',
            'image' => $file,
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.menus.store'), $data);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success', 'Menu created successfully');

        $this->assertDatabaseHas('menus', [
            'name' => 'Nasi Goreng',
            'price' => 35000,
        ]);

        $menu = Menu::first();
        Storage::assertExists($menu->image);
        $this->assertCount(2, $menu->categories);
    }

    /** @test */
    public function store_menu_requires_name_price_description_and_image()
    {
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.menus.store'), []);

        $response->assertSessionHasErrors(['name', 'price', 'description', 'image']);
    }

    /** @test */
    public function store_menu_price_must_be_numeric()
    {
        $data = [
            'name' => 'Sate',
            'price' => 'bukan angka',
            'description' => 'Enak',
            'image' => UploadedFile::fake()->image('sate.jpg'),
        ];

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.menus.store'), $data);

        $response->assertSessionHasErrors(['price']);
    }

    /** @test */
    public function admin_can_view_edit_menu_form()
    {
        $menu = Menu::factory()->create();
        Category::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.menus.edit', $menu->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.menus.edit');
        $response->assertViewHas('menu', $menu);
        $response->assertViewHas('categories');
    }

    /** @test */
    public function admin_can_update_menu_without_changing_image()
    {
        $menu = Menu::factory()->create([
            'name' => 'Old Name',
            'price' => 10000,
            'description' => 'Old Desc',
            'image' => 'public/menus/old.jpg'
        ]);

        $updatedData = [
            'name' => 'New Name',
            'price' => 20000,
            'description' => 'New Desc',
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.menus.update', $menu->id), $updatedData);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success', 'Category updated successfully'); // sesuai controller

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'New Name',
            'price' => 20000,
            'description' => 'New Desc',
            'image' => 'public/menus/old.jpg'
        ]);
    }

    /** @test */
    public function admin_can_update_menu_with_new_image_and_sync_categories()
    {
        Storage::fake();

        $oldImage = 'public/menus/old.jpg';
        Storage::put($oldImage, 'dummy');

        $menu = Menu::factory()->create(['image' => $oldImage]);
        $oldCategories = Category::factory()->count(2)->create();
        $menu->categories()->attach($oldCategories->pluck('id'));

        $newCategories = Category::factory()->count(2)->create();
        $newFile = UploadedFile::fake()->image('new.jpg');

        $data = [
            'name' => 'Updated Menu',
            'price' => 99999,
            'description' => 'Updated desc',
            'image' => $newFile,
            'categories' => $newCategories->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.menus.update', $menu->id), $data);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success', 'Category updated successfully');

        $menu->refresh();
        Storage::assertExists($menu->image);
        Storage::assertMissing($oldImage);
        $this->assertCount(2, $menu->categories);
        foreach ($newCategories as $cat) {
            $this->assertDatabaseHas('category_menu', [
                'menu_id' => $menu->id,
                'category_id' => $cat->id,
            ]);
        }
    }

    /** @test */
    public function update_menu_requires_name_price_and_description()
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.menus.update', $menu->id), [
                             'name' => '',
                             'price' => '',
                             'description' => '',
                         ]);

        $response->assertSessionHasErrors(['name', 'price', 'description']);
    }

    /** @test */
    public function update_menu_price_must_be_numeric()
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.menus.update', $menu->id), [
                             'name' => 'Valid',
                             'price' => 'invalid',
                             'description' => 'Valid',
                         ]);

        $response->assertSessionHasErrors(['price']);
    }

    /** @test */
    public function admin_can_delete_menu_and_detach_categories()
    {
        Storage::fake();

        $imagePath = 'public/menus/to-delete.jpg';
        Storage::put($imagePath, 'dummy');

        $menu = Menu::factory()->create(['image' => $imagePath]);
        $categories = Category::factory()->count(2)->create();
        $menu->categories()->attach($categories->pluck('id'));

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.menus.destroy', $menu->id));

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success', 'Category deleted successfully');

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
        $this->assertDatabaseMissing('category_menu', ['menu_id' => $menu->id]);
        Storage::assertMissing($imagePath);
    }

    /** @test */
    public function guest_cannot_access_admin_menus()
    {
        $response = $this->get(route('admin.menus.index'));
        $response->assertRedirect(route('login'));
    }
}