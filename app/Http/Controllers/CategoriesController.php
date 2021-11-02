<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Categories;
use App\Models\favourites;
use Carbon\Carbon;

class CategoriesController extends Controller
{
    public function showing($category, $type_of_fashion)
    {
        $data = Categories::with('media')->where([
            ['category', '=', $category],
            ['type_of_fashion', '=', $type_of_fashion]

        ])->get();
        // $data->map(function($news) {
        // return $news;
        // })->flatten();

        // $data1= Categories::find(1)->getMedia();
        return $data;
    }
    public function showBookings($barrier_id)
    {
        $data =  Categories::with('media')
            ->join('Bookings', 'Categories.id', '=', 'Bookings.category_id')
            ->where('Bookings.barrier_id', $barrier_id)
            ->get();
            $data1 =  Categories::
            join('media', 'Categories.id', '=', 'media.model_id')
            ->where('media.model_id', $data[0]->category_id)
            ->get();
        return $data1;
    }
    public function showFavourites($barrier_id)
    {
        $data =  Categories::with('media')
            ->join('favourites', 'Categories.id', '=', 'favourites.category_id')
            ->where('favourites.barrier_id', $barrier_id)
            ->get();
            $data1 =  Categories::
            join('media', 'Categories.id', '=', 'media.model_id')
            ->where('media.model_id', $data[0]->category_id)
            ->get();

        return $data1;
    }
    public function addBooking($barrier_id, $category_id)
    {
        $booking = new Bookings();
        $booking->barrier_id = $barrier_id;
        $booking->booking_date = Carbon::now();
        $booking->category_id = $category_id;
        $booking->save();
        return "Added";
    }
    public function addFavourite($barrier_id, $category_id)
    {
        $favourites = new favourites();
        $favourites->barrier_id = $barrier_id;
        $favourites->favourite_date = Carbon::now();
        $favourites->category_id = $category_id;
        $favourites->save();
        return "Added";
    }
    public function deleteBooking($barrier_id, $category_id)
    {echo"hii";
        Bookings::where([
            ['barrier_id', '=', $barrier_id],
            ['category_id', '=', $category_id]
        ])
            ->delete();


        return "Deleted From Booking";
    }
    public function deleteFavourite($barrier_id, $category_id)
    {
        favourites::where([
            ['barrier_id', '=', $barrier_id],
            ['category_id', '=', $category_id]
        ])
            ->delete();


        return "Deleted From Favourites";
    }
    function search($categoryName)
    {
        return Categories::where("name", "like", "%" . $categoryName . "%")->take(10)->get();
    }
}
