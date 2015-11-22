<?php

class CategoryController extends BaseController {

    public static function categories() {
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $user_id = $user->id;
        $categories = Category::all($user_id);
        View::make('category/categories.html', array('categories' => $categories));
    }

    public static function edit_category($id) {
        self::check_logged_in();
        $category = Category::find($id);
        View::make('category/edit_category.html', array('category' => $category));
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description'],
        );
        $category = new Category($attributes);
        $errors = $category->errors();

        if (count($errors) > 0) {
            View::make('category/edit_category.html', array('errors' => $errors, 'category' => $category));
        } else {
            Category::update($id, $attributes);
            Redirect::to('/categories', array('message' => 'Kategorian tallennus onnistui!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $category = new Category(array('id' => $id));
        $category->destroy($id);
        Redirect::to('/categories', array('message' => 'Kategoria poistettiin!'));
    }

}
