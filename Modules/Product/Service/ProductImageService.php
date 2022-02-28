<?php

namespace Modules\Product\Service;

use App\Service\ImageService;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;

class ProductImageService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(Product $product, $image)
    {
        $productImage = new ProductImage([
            'path' => $this->imageService->storeImage($image),
            'thumbnail_path' => $this->imageService->storeImage($image),
        ]);

        $this->imageService->createThumbnail( Storage::path($productImage['thumbnail_path']), null, 350);

        $product->images()->save($productImage);

        return $productImage;
    }

    public function delete(Product $product)
    {
        foreach($product->images as $productImage) {
            $this->imageService->unlinkImage($productImage->path);
            $this->imageService->unlinkImage($productImage->thumbnail_path);
            $productImage->delete();
        }
        
        return true;
    }
}
