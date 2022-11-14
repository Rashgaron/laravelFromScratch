<div class="form-group">
    <label for="title"></label>
    <input id="title" type="text" class="form-control" name="title"
        value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="form-group">
    <label for="content"></label>
    <textarea class="form-control" id="content" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
<div class="form-group">
    <label>Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control-file">
</div>
<x-errors :errors="$errors" />
