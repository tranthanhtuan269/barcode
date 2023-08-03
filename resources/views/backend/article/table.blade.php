@foreach($articles as $data)
<tr>
    <td>
        <input type="checkbox" name="selectCol" class="check-article" value="{{ $data->id }}" data-column="{{ $data->id }}">
    </td>
    <td>
        <img src="/filemanager/thumbs-images/{{ $data->image }}" width="60">
    </td>
    <td>
        <a href="/{{ $data->slug }}" title="Sửa">{{ $data->title }}</a>
    </td>
    <td class="text-center">
        {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->created_at, 'd/m/Y')}}
    </td>
    <td class="text-center">
        {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->updated_at, 'd/m/Y')}}
    </td>
    <td>
        <a href="/admincp/articles/{{ $data->id }}/edit?language=en"  class="btn-edit" title="Sửa"><i class="fa fa-edit"></i></a>
    </td>
</tr>
@endforeach