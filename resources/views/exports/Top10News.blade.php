<style>
    thead tr th {
        vertical-align: middle;
    }

    .header-table th {
        text-align: center;
        border: 1px solid #777;
    }
</style>
<table>
    <thead>
    <tr>
        <th colspan="10" style="text-align: center;font-weight: bold;">
            {{!empty($title) ? $title : 'Booking'}}
        </th>
        <th colspan="4" style="text-align: center;font-weight: bold;">
                <p>{{!empty($from) ? 'Từ ngày:'.$from : ''}}</p>
        </th>
        <th colspan="4" style="text-align: center;font-weight: bold;">
                <p>{{!empty($to) ? 'Đến ngày: '.$to : ''}}</p>
        </th>
    </tr>
    <tr>

    </tr>
    <tr class="header-table">
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">STT</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Tên Tin</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Số Lượt xem</th>
        {{-- <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Nội dung</th> --}}
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Danh Mục Tin</th>




    </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $key => $item)
            <tr>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{$key +1}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['name']) ? $item['name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['view']) ? $item['view'] : ''}}</td>
                {{-- <td colspan="2" dangerouslySetInnerHTML={{ __html: !empty($item['content']) ? $item['content'] : '' }} style="border: 1px solid #777; text-align: left"></td> --}}
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item ->news_category->name) ? $item ->news_category->name : ''}}</td>


            </tr>
        @endforeach
    @endif
    </tbody>
</table>