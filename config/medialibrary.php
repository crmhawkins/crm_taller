<?php

return [

    'disk_name' => 'public',

    'max_file_size' => 1024 * 1024 * 10, // 10 MB

    'queue_name' => '',

    'media_model' => Spatie\MediaLibrary\MediaCollections\Models\Media::class,

    's3' => [
        'domain' => 'https://your-domain.s3.amazonaws.com',
    ],

    'url_generator' => null,

    'version_urls' => false,

    'path_generator' => null,

    'image_optimizers' => [
        Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
            '-m85', // set maximum quality to 85%
            '--strip-all', // this strips out all text information such as comments and EXIF data
            '--all-progressive', // this will make sure the resulting image is a progressive one
        ],
        Spatie\ImageOptimizer\Optimizers\Pngquant::class => [
            '--force', // required parameter for this package
        ],
        Spatie\ImageOptimizer\Optimizers\Optipng::class => [
            '-i0', // this will result in a non-interlaced, progressive scanned image
            '-o2', // this set the optimization level to two (multiple IDAT compression trials)
            '-quiet', // required parameter for this package
        ],
        Spatie\ImageOptimizer\Optimizers\Svgo::class => [
            '--disable=cleanupIDs', // disabling because it is known to cause troubles
        ],
        Spatie\ImageOptimizer\Optimizers\Gifsicle::class => [
            '-b', // required parameter for this package
            '-O3', // this produces the slowest but best results
        ],
        Spatie\ImageOptimizer\Optimizers\Cwebp::class => [
            '-m 6', // for the slowest compression method in order to get the best compression.
            '-pass 10', // for maximizing the amount of analysis pass.
            '-mt', // multithreading for some speed improvements.
            '-q 90', // quality factor that brings the least noticeable changes.
        ],
    ],

    'image_generators' => [
        Spatie\MediaLibrary\ImageGenerators\FileTypes\Image::class,
        Spatie\MediaLibrary\ImageGenerators\FileTypes\Webp::class,
        Spatie\MediaLibrary\ImageGenerators\FileTypes\Pdf::class,
        Spatie\MediaLibrary\ImageGenerators\FileTypes\Svg::class,
        Spatie\MediaLibrary\ImageGenerators\FileTypes\Video::class,
    ],

    'temporary_directory_path' => storage_path('medialibrary/temp'),

    'ffmpeg_binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),

    'ffprobe_binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),

    'ffmpeg_threads' => 12,

    'ffmpeg_temporary_directory' => null,

    'ffmpeg_log_level' => env('FFMPEG_LOG_LEVEL', 'error'),

    'ffmpeg_log_file' => env('FFMPEG_LOG_FILE', null),

    'ffmpeg_timeout' => 3600,

    'ffmpeg_max_memory' => env('FFMPEG_MAX_MEMORY', '512M'),

];