<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Category Form</title>
        <!-- <link rel="stylesheet" href="{{ url('category-subcategory-assets/css/bootstrap.min.css') }}"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ url('category-subcategory-assets/css/style.css') }}">
    </head>
    <body>

        @include('category-subcategory.includes.menu')

        <div class="container">

            @include('category-subcategory.includes.notification')

            <h2 class="text-center">Laravel Drag, Drop and Sort Categories SubCategories using JQuery</h2>

            <h4> List of Category</h4>

            <div class="row">
                <div class="col-md-12 dd" id="nestable-wrapper">
                    <ol class="dd-list list-group">
                        @foreach($categories as $k => $category)
                            <li class="dd-item list-group-item" data-id="{{ $category['category_id'] }}" >
                                <div class="dd-handle" >{{ $category['name'] }}</div>
                                <div class="dd-option-handle">
                                    <a href="{{ route('category-subcategory.edit', ['category_id' => $category['category_id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>
                                    <a href="{{ route('category-subcategory.remove', ['category_id' => $category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>
                                </div>

                                @if(!empty($category->categories))
                                    @include('category-subcategory.child-includes.child-category-view', [ 'category' => $category])
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <div class="row">
                <form action="{{ route('category-subcategory.save-nested-categories') }}" method="post">
                    @csrf
                    <textarea style="display: none;" name="nested_category_array" id="nestable-output"></textarea>
                    <button type="submit" class="btn btn-success" style="margin-top: 15px;" >Save category</button>
                </form>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script src="{{ url('category-subcategory-assets/js/jquery.nestable.js') }}"></script>
        <script src="{{ url('category-subcategory-assets/js/style.js') }}"></script>

    </body>
</html>
