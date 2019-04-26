<ul class="mt-1">
    @foreach($childs as $child)
        <li class="mb-1">
            @if(count($child->childs))
                <i class="indicator fas fa-plus-circle"></i>
            @endif
            {{ $child->title }}
            <div class="btn-group float-right mr-5 border border-primary rounded">
                <button class="btn btn-sm btn-primary d-block p-1 px-2 btn-edit-category" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Delete" data-target="#modal-campaign-edit" data-category-title="{{$child->title}}" data-action = "{{Route('categories.update', [$child->id])}}">
                    <i class="fa fa-pencil-alt"></i>
                </button>
                <button type="button" class="btn-delete btn btn-sm btn-danger d-block p-1 px-2 btn-delete-category" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Delete" data-target="#modal-campaign-delete" data-action = "{{Route('categories.delete', [$child->id])}}">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            @if(count($child->childs))
                @include('category.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>