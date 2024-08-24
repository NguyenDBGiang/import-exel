<?php
namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileUpload
{
    const ALLOW_IMAGE_EXTENSION = array(
        'jpg', 'jpeg', 'png', 'webp', 'gif'
    );

    const ALLOW_FILE_EXTENSION = array(
       'doc', 'docx', 'xls', 'xlsx', 'pdf'
    );

    public static function doUpload(UploadedFile $file, array $options = array()) 
    {
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '-' . Str::random(8) . '-' . $originalFileName;
        $fileSize = $file->getSize();
        $listExtension = array_merge(self::ALLOW_IMAGE_EXTENSION, self::ALLOW_FILE_EXTENSION);
        if (isset($options['file_extension'])) $listExtension = $options['file_extension'];
        if(!self::checkFileAllowExtension(strtolower($fileName), $listExtension)) {
            return array(
                'success' => false,
                'msg' => 'File phải có định dạng thuộc: ' . implode(',', $listExtension)
            );
        }
        if(!self::checkFileAllowSize($fileSize)){
            return array(
                'success' => false,
                'msg' => 'File phải có kích thước < 3MB: '
            );
        }

        return array(
            'success' => true,
            'file_name' => $originalFileName,
        );
    }

    public static function checkFileAllowSize($fileSize)
    {
        return $fileSize <= 3 * 1024 * 1024;
    }

    public static function checkFileAllowExtension($filename, $listExtension = self::ALLOW_IMAGE_EXTENSION)
    {
        $fileExtension = File::extension($filename);
        return in_array(strtolower($fileExtension), $listExtension);
    }
}
