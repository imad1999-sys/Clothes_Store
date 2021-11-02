<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Categories;
use App\Models\favourites;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function categoryById($id)
    {
        $Category = Categories::where('id', '=', $id)->with('media')->get();
        return $Category;
    }

    public function storing(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'category' => 'required',
            'type_of_fashion' => 'required',
            'size' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        $categories = new Categories();
        $categories->name = $req->input('name');
        $categories->category = $req->input('category');
        $categories->type_of_fashion = $req->input('type_of_fashion');
        $categories->size = $req->input('size');
        $categories->price = $req->input('price');
        $categories->image = $req->file('image');
        $categories->save();
        $categories->addMedia($req->file('image'))
            ->toMediaCollection();
        return "Category Added";
    }

    public function showing()
    {
        $Category = Categories::with('media')->get();
        return $Category;
    }


    public function numOf($type)
    {
        if ($type == "Categories") {
            $numOfData = Categories::count();
        } elseif ($type == "Bookings") {
            $numOfData = Bookings::count();
        } elseif ($type == "Favourites") {
            $numOfData = Favourites::count();
        }
        return  $numOfData;
    }



    public function updating($id, Request $req)
    {
        $categories = Categories::find($id);
        $categories->name = $req->input('name');
        $categories->category = $req->input('category');
        $categories->type_of_fashion = $req->input('type_of_fashion');
        $categories->size = $req->input('size');
        $categories->price = $req->input('price');
        $categories->save();
        if( $categories->image = $req->file('image')){
        $categories->media()->delete($id); // delete previous image in the database
        $categories->clearMediaCollection();
        if ($categories->hasMedia('image')) {
            $categories->updateMedia($req->file('image'), 'media'); //images === collection name
        } else {
            $categories->addMediaFromRequest('image')
                ->toMediaCollection('media');
        }}
        return "Category Updated";
    }


    public function deleting($id)
    {
        $data = Categories::find($id);
        favourites::where([
            ['category_id', '=', $id],
        ])->delete();
        Bookings::where([
            ['category_id', '=', $id],
        ])->delete();
        if ($data) {
            $data->delete($id);
            $data->clearMediaCollection();
            return "Category Deleted";
        } else return "Category Not exist";
    }


    function search($name)
    {
        if($name==null){
            return Categories::all();
        }
        else
        return Categories::where("name", "like", "%" . $name . "%")->with('media')->take(10)->get();
    }
}
