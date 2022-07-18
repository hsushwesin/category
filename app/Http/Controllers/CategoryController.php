<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where(['parent_id' => 0])->orderBy('sort_order', 'ASC')->get();

        return view('category-subcategory.list', compact('categories'));
        // return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('sort_order', 'ASC')->get();

        return view('category-subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable',
        ]);
        $query = [
            'name' => $request->name,
            'parent_id' => (!empty($request->parent_id))? $request->parent_id : 0,
        ];
        $category = Category::updateOrCreate(['category_id' => $request->category_id], $query);

        return redirect(route('category-subcategory.edit', ['category_id' => $category->category_id]))->with('success', "Successfully saved.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $info = [
            'categories' => category::orderBy('name', 'ASC')->get(),
            'category' => category::find($request->category_id),
        ];

        return view('category-subcategory.create', $info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->category_id);
        $category->delete();

        return redirect(route('category-subcategory.list'))->with('success', "Category removed successfully.");
    }
    public function saveNestedCategories(Request $request){

        $json = $request->nested_category_array;
        $decoded_json = json_decode($json, TRUE);

        $simplified_list = [];
        $this->recur1($decoded_json, $simplified_list);

        foreach($simplified_list as $key => $value){
            $category = Category::find($value['category_id']);
            $category->fill([
                "parent_id" => $value['parent_id'],
                "sort_order" => $value['sort_order'],
            ]);

            $category->save();
        }
         return redirect(route('category-subcategory.list'));
        // return response()->json(['status'=>'success']);
    }

    public function recur1($nested_array=[], &$simplified_list=[]){

        static $counter = 0;

        foreach($nested_array as $key => $value){

            $sort_order = $key+1;
            $simplified_list[] = [
                "category_id" => $value['id'],
                "parent_id" => 0,
                "sort_order" => $sort_order
            ];

            if(!empty($value["children"])){
                $counter+=1;
                $this->recur2($value['children'], $simplified_list, $value['id']);
            }
            break;

        }
    }

    public function recur2($sub_nested_array=[], &$simplified_list=[], $parent_id = NULL){

        static $counter = 0;

        foreach($sub_nested_array as $key => $value){

            $sort_order = $key+1;
            $simplified_list[] = [
                "category_id" => $value['id'],
                "parent_id" => $parent_id,
                "sort_order" => $sort_order
            ];

            if(!empty($value["children"])){
                $counter+=1;
                return $this->recur2($value['children'], $simplified_list, $value['id']);
            }
        }
    }
}
