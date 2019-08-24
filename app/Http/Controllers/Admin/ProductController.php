<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Product;
use App\Helpers\UploadAdmin;
use App\Http\Resources\Admin\ProductDetailResource;
use App\Http\Resources\Admin\ColorResource;
use App\File;
use App\Color;


class ProductController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $products = Product::get();
        return ProductResource::collection($products);
    }

    public function order()
    {
        $products = Product::getByOrder();
        return ProductResource::collection($products);
    }

    public function filter()
    {
        $products = Product::getByFilter();
        return ProductResource::collection($products);
    }

    public function delete($id)
    {
        if (Product::ofId($id)->delete())
            return response()->json(['status' => true]);
        return response()->json(['status' => false], 500);
    }

    public function changeState($id)
    {
        $product = Product::ofId($id)->first();
        if ($product->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $product->update([
            'status' => $status
        ]);

        return $product;
    }

    public function detail($id)
    {
        return new ProductDetailResource(Product::ofId($id)->first());
    }

    public function updateDetail()
    {
        $product = Product::updateDetail();
        return $product;
    }

    public function uploadMultiImages()
    {
        $product = Product::ofId(request('id'))->first();
        $newImages = request('newImages');
        foreach($newImages as $newImage)
        {
        
            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image($newImage, 'product'))
            {
                $file = new File();
                $file->set($result, 0, 0, 3);
                $product->files()->save($file);
            }
        }
        
        return $product;
    }
    
    public function removeImage($id)
    {
        return File::ofId($id)->delete();
    }

    public function adddColor($color,$id)
    {
        $product = Product::ofId($id)->first();
        $color = Color::find($color);
        $product->colors()->attach($color->id);

        return [
            'id' => $color->id ?? 0,
            'name' => $color->name ?? "",
            'code' => $color->code ?? "",
        ];;
    }
}
