<h4 class="title-fuction">Danh mục</h4>
<p><a href="{{ route('getSearchBarCode') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Tìm kiếm Barcode</a></p>
<p><a href="{{ route('listBarCodebyUser',['id'=>Auth::user()->id ]) }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Danh sách BarCode đang quản lý</a></p>
