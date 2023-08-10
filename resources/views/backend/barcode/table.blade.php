@foreach($articles as $data)
<tr>
    <td>
        <input type="checkbox" name="selectCol" class="check-article" value="{{ $data->id }}" data-column="{{ $data->id }}">
    </td>
    <td>
        <img src="/uploads/barcode/{{ $data->image }}" width="60">
    </td>
    <td>
        <a href="/admincp/barcodes/{{ $data->id }}/edit?language=en" title="Sửa">{{ $data->name }}</a>
    </td>
    <td class="text-center">
        {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->created_at, 'd/m/Y', $data->updated_at)}}
    </td>
    <td class="text-center">
        {{App\Helpers\Helper::formatDate('Y-m-d H:i:s', $data->updated_at, 'd/m/Y', $data->updated_at)}}
    </td>
    <td>
        <a href="/admincp/barcodes/{{ $data->id }}/edit?language=en"  class="btn-edit" title="Sửa"><i class="fa fa-edit"></i></a>
    </td>
</tr>
@endforeach