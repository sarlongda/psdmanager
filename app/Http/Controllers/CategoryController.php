<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;


class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::pluck('title','id')->all();


        return view('category.categoryTreeview',compact('categories','allCategories'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

        Category::create($input);
        return back()->with('success', 'New Category added successfully.');
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
        $this->validate($request, [
            'title' => 'required',
        ]);
        $category = Category::findOrFail($id);
        $category->title = $request->title;
        $category->save();
        return back()->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->remove_branch($id);

        return back()->with('success', 'Category deleted successfully.');
    }

    private function remove_branch($id)
    {
        $category = Category::findOrFail($id);
        if(count($category->childs)>0){
            foreach ($category->childs as $child){
                $this->remove_branch($child->id);
            }
        }
        $category->delete();
    }
}