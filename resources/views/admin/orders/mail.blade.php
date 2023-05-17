<head>
    <style>
        table, tr, td, th {
            border: 1px solid rgb(207, 205, 205);
            border-collapse: collapse;
            width: 500px;
        }

        td, th {
            padding: 10px;
        }

        th {
            color: white;
            background-color:#CF111A;
            font-weight: bold;
        }
    </style>
</head>
<html>
    <body>
        <table>
            <tr>
                <th>Mã đơn hàng</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th>Khách hàng</th>
                <td>{{ \App\Models\User::find($order->user_id)->name }}</td>
            </tr>
            <tr>
                <th>Tổng tiền</th>
                <td>{{ number_format($order->total,-3,',',',') }} VND</td>
            </tr>
            <tr>
                <th>Mã khuyến mãi</th>
                <td>{{ !is_null($order->voucher_code) ? $order->voucher_code : 'Không có' }}</td>
            </tr>
            <tr>
                <th>Ngày đặt hàng</th>
                <td>{{ date('d/m/Y H:i:s',strtotime($order->created_at)) }}</td>
            </tr>
            <tr>
                <th>Địa chỉ nhận hàng</th>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <th>Trạng thái đơn hàng</th>
                <td>
                    @if ($status == 0)
                        Chờ xác nhận
                    @elseif ($status == 1)
                        Xác nhận
                    @elseif ($status == 2)
                        Hoàn thành
                    @elseif ($status == 3)
                        Hủy
                    @endif
                </td>
            </tr>
        </table>
    </body>
</html>