@extends('layouts.modal')

@section('content')

<section id="item-create-modal">
<h3>@lang('modals.specify_new_item')</h3>
<h6>(@lang('modals.the_more_you_specify_about_the_item_the_more_you_can_save'))</h6>

<form action="" method="post"  id="item-add-form" >
    {{ csrf_field() }}

    <div class="error-message" id="error-message"></div>

    <p>
        <label for="name">@lang("create_order.name")</label>
        <input name="name" id="name" value="{{ old('name') }}" required>
    </p>

    <section class="columns">
        <article class="col col4 ">
            <p class="measurement">
                <label for="length">@lang("create_order.length")</label>
                <input name="length" id="length" value="{{ old('length') }}" placeholder="cm">
            </p>
        </article>
        <article class="col col4">
            <p class="measurement">
                <label for="width">@lang("create_order.width")</label>
                <input name="width" id="width" value="{{ old('width') }}" placeholder="cm">
            </p>
        </article>
        <article class="col col4">
            <p class="measurement">
                <label for="height">@lang("create_order.height")</label>
                <input name="height" id="height" value="{{ old('height') }}" placeholder="cm">
            </p>
        </article>
        <article class="col col4">
            <p class='measurement'>
                <label for="name">@lang("create_order.m3")</label>
                <div id="size"></div>
                <input type="hidden" name="size" id="size_input">
            </p>
        </article>
    </section>

    <div class="input-group number-spinner">
    @lang('create_order.amount')
        <span class="input-group-btn">
            <button class="btn btn-default" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
        </span>
        <input type="text" class="form-control text-center" name="amount" value="1">
        <span class="input-group-btn">
            <button class="btn btn-default" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
        </span>
    </div>

    <p>
        <input type="checkbox" name="assemb_dissasemb_need" value="1 " id="assemb_dissasemb_need"> @lang('create_order.assembly_dissasembly_neede')<br>
    </p>
    <p>
        <input type="checkbox" name="fit_to_elevator" value="1"  id="fit_to_elevator">@lang('create_order.does_not_fit_in_the_elevator')<br>
    </p>
    <p>
        <input type="checkbox" name="packaking_need" value="1"  id="packaking_need">@lang('create_order.do_you_need_packaging')<br>
    </p>


<h4>@lang('create_order.upload_images')</h4>
<div class="dropzone dropzone-previews" id="file-upload"></div>
<div id="uploaded_filesas">

</div>
<p>
 <label for="description">@lang("create_order.description")</label>
     <textarea name="description" id="description" value="{{ old('description') }}"></textarea>
</p>

</form>

</section>

@endsection
