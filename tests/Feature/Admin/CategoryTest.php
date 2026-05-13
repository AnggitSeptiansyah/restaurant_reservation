<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryTest extends TestCase
{
     use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Buat user dengan is_admin = true
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }


    /** @test */
    public function admin_can_view_categories_index()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
        $response->assertViewHas('categories');
        $this->assertCount(3, $response->viewData('categories'));
    }

    /** @test */
    public function admin_can_view_create_category_form()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.categories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.create');
    }

    /** @test */
    public function admin_can_store_new_category()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('category.jpg');
        $data = [
            'name' => 'Main Course',
            'description' => 'Delicious main dishes',
            'image' => $file,
        ];

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category created successfully');

        $this->assertDatabaseHas('categories', [
            'name' => 'Main Course',
            'description' => 'Delicious main dishes',
        ]);

        $category = Category::first();
        $this->assertNotNull($category->image);
        Storage::assertExists($category->image);
    }

    /** @test */
    public function store_category_requires_name_description_and_image()
    {
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.categories.store'), []);

        $response->assertSessionHasErrors(['name', 'description', 'image']);
    }

    /** @test */
    public function admin_can_view_edit_category_form()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.categories.edit', $category->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.edit');
        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function admin_can_update_category_without_new_image()
    {
        $category = Category::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old Desc',
            'image' => 'public/categories/old.jpg'
        ]);

        $updatedData = [
            'name' => 'New Name',
            'description' => 'New Description',
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.categories.update', $category->id), $updatedData);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category updated successfully');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'New Name',
            'description' => 'New Description',
            'image' => 'public/categories/old.jpg' // image tidak berubah
        ]);
    }

    /** @test */
    public function admin_can_update_category_with_new_image()
    {
        Storage::fake('public');

        $category = Category::factory()->create([
            'image' => 'public/categories/old.jpg'
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg');
        $data = [
            'name' => 'Updated',
            'description' => 'Updated desc',
            'image' => $newFile,
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.categories.update', $category->id), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $category->refresh();
        Storage::assertExists($category->image);
        // Pastikan file lama terhapus (karena Storage::fake, kita check missing)
        Storage::assertMissing('public/categories/old.jpg');
    }

    /** @test */
    public function update_category_requires_name_and_description()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.categories.update', $category->id), [
                             'name' => '',
                             'description' => ''
                         ]);

        $response->assertSessionHasErrors(['name', 'description']);
    }

    /** @test */
    public function admin_can_delete_category_and_detach_menus()
    {
        $category = Category::factory()->create();
        $menu = \App\Models\Menu::factory()->create();
        $category->menus()->attach($menu->id);

        // Simulasikan file gambar
        Storage::fake('public');
        $imagePath = 'public/categories/to-delete.jpg';
        Storage::disk('public')->put($imagePath, 'fake content');
        $category->update(['image' => $imagePath]);

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.categories.destroy', $category->id));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category deleted successfully');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('category_menu', ['category_id' => $category->id]);
        Storage::assertMissing($imagePath);
    }

    /** @test */
    public function guest_cannot_access_admin_categories()
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertRedirect(route('login')); // atau sesuai redirect guest

        $response = $this->post(route('admin.categories.store'), []);
        $response->assertRedirect(route('login'));
    }
}
