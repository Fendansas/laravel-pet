<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function getDepartments(int $perPage = 10)
    {
        return Department::orderBy('id', 'desc')->paginate($perPage);
    }

    public function createDepartment(array $data): Department
    {
        return Department::create($data);
    }

    public function updateDepartment(Department $department, array $data): bool
    {
        return $department->update($data);
    }

    public function deleteDepartment(Department $department): bool
    {
        return $department->delete();
    }

    public function findById(int $id): ?Department
    {
        return Department::find($id);
    }
}
