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
        <th colspan="12" style="text-align: center;font-weight: bold;">Tổng doanh thu theo từng chuyên khoa</th>
    </tr>
    <tr>

    </tr>
    <tr class="header-table">
        {{-- <th colspan="2" style="text-align: left; font-weight: bold;">Mã chuyên khoa</th> --}}
        <th colspan="2" style="text-align: left; font-weight: bold;">Tên chuyên khoa</th>
        <th colspan="2" style="text-align: left; font-weight: bold;">Tổng doanh thu</th>

    </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $key => $item)
            <tr>
                {{-- <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['specialists_name']) ? $item['code'] : ''}}</td> --}}
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['specialists_name']) ? $item['specialists_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: right">{{!empty($item['price']) ? number_format($item['price']) . " đ" : ''}}</td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>