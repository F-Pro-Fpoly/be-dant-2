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
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Phòng ban</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Code lịch khám</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Bác sĩ</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Trạng thái</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Chuyên khoa</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Vaccine</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Payment_method</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Người khám</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Ngày sinh</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Điện thoại</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Email</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Địa chỉ người dùng</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Quận huyện</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Khu vực</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Lý do hủy</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Mô tả</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Thông tin sau khám</th>
        <th colspan="2" style="text-align: left; font-weight: bold; border: 1px solid #777;">Ngày tạo</th>

    </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $key => $item)
            <tr>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['STT']) ? $item['STT'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['department_name']) ? $item['department_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['schedule_name']) ? $item['schedule_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['doctor_name']) ? $item['doctor_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['status_name']) ? $item['status_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['specialist_name']) ? $item['specialist_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['vaccine_name']) ? $item['vaccine_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['payment_method']) ? $item['payment_method'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['customer_name']) ? $item['customer_name'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['birthday']) ? $item['birthday'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['phone']) ? $item['phone'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['email']) ? $item['email'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['address']) ? $item['address'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['district_code']) ? $item['district_code'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['ward_code']) ? $item['ward_code'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['reasonCancel']) ? $item['reasonCancel'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['description']) ? $item['description'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{ !empty($item['infoAfterExamination']) ? $item['infoAfterExamination'] : ''}}</td>
                <td colspan="2" style="border: 1px solid #777; text-align: left">{{!empty($item['created_at']) ? $item['created_at'] : ''}}</td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>