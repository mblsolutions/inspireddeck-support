@foreach ($selectList as $item)
    <option value="{{ $item['id'] }}" @if (isset($selected) && $item['id'] == $selected) selected @endif>{{ $item['name'] }}</option>
@endforeach