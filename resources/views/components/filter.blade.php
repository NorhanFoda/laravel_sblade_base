<div>
    <form id="filter" {{ $attributes }}>
        <input type="text" name="keyword" placeholder="Keyword">
        {{ $slot }} <!-- This allows additional form fields to be passed -->
        <button type="submit">Filter</button>
    </form>
</div>
