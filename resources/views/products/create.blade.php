<x-app-layout title="{{$page_meta['title']}}">
    <form action="{{ $page_meta['url'] }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Product Name" required>

        <select name="category_id" required>
            <option value="" disabled selected>Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
        </select>

        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="teaser" placeholder="Teaser" required>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="file" name="images[]" multiple accept="image/*" required>
        <button type="submit">Submit</button>
    </form>

</x-app-layout>
