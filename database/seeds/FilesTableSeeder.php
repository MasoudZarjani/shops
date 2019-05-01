<?php

use Illuminate\Database\Seeder;
use App\File as FileModel;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::get("database/data/files.json");
        $files = json_decode($files);
        foreach ($files as $file) {
            $fileModel = new FileModel();
            $fileModel->path = $file->path;
            $fileModel->size = $file->size;
            $fileModel->type = $file->type;
            $fileModel->position = $file->position;
            $fileModel->file_able_type = $file->file_able_type;
            $fileModel->file_able_id = $file->file_able_id;
            $fileModel->save();
        }
    }
}
