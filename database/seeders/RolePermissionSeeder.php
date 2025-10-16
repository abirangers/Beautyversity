<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions for Kelas Digital.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Course Management
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'publish courses',
            'unpublish courses',
            
            // Lesson Management
            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',
            
            // Article Management
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            
            // Enrollment Management
            'view enrollments',
            'manage enrollments',
            'approve enrollments',
            'reject enrollments',
            
            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Tag Management
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
            
            // Admin Panel Access
            'access admin panel',
            'view dashboard',
            'view reports',
            
            // Student specific permissions
            'enroll courses',
            'view enrolled courses',
            'access course content',
            'complete lessons',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Student role
        $studentRole = Role::updateOrCreate(['name' => 'student']);
        $studentRole->syncPermissions([
            'view courses',
            'view lessons',
            'view articles',
            'enroll courses',
            'view enrolled courses',
            'access course content',
            'complete lessons',
        ]);

        // Content Manager role - Limited to article management only
        $contentManagerRole = Role::updateOrCreate(['name' => 'content-manager']);
        $contentManagerRole->syncPermissions([
            // Article Management Only
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
            // Admin Panel Access (for dashboard)
            'access admin panel',
            'view dashboard',
        ]);

        // Instructor role - Limited to course management only
        $instructorRole = Role::updateOrCreate(['name' => 'instructor']);
        $instructorRole->syncPermissions([
            // Course Management Only
            'view courses',
            'create courses',
            'edit courses',
            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',
            // Admin Panel Access (for dashboard)
            'access admin panel',
            'view dashboard',
        ]);

        // Admin role
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'publish courses',
            'unpublish courses',
            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            'view enrollments',
            'manage enrollments',
            'approve enrollments',
            'reject enrollments',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
            'access admin panel',
            'view dashboard',
            'view reports',
        ]);

        // Super Admin role - gets all permissions via Gate::before rule
        $superAdminRole = Role::updateOrCreate(['name' => 'Super-Admin']);
        // All permissions are granted automatically via Gate::before in AuthServiceProvider

        $this->command->info('Roles and permissions created successfully!');
    }
}

