@extends('layouts.template')

<style>
    /* สไตล์สำหรับแสดงผลปกติ */
    .sm-table th {
        font-size: 0.85rem;
        color: #333 !important;
        font-weight: bold;
    }

    .sm-table td {
        background-color: #ffffff !important;
    }

    .bg-condition {
        background-color: #fff8e1 !important;
    }

    /* สีเหลืองอ่อน */
    .bg-action {
        background-color: #fbe9e7 !important;
    }

    /* สีส้มอ่อน */

    /* สไตล์สำหรับการพิมพ์ PDF */
    @media print {

        .no-print,
        .layout-menu,
        .layout-navbar,
        .content-footer {
            display: none !important;
        }

        .layout-page {
            padding: 0 !important;
        }

        .container-xxl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card {
            border: 1px solid #ccc !important;
            box-shadow: none !important;
            break-inside: avoid;
            margin-bottom: 10px !important;
        }

        body {
            background: white !important;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }
    }
</style>

@section('content')
<div class="container-xxl flex-grow-1 container-p-y font-fc">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm no-print">
        <h4 class="mb-0 fw-bold text-primary">DASHBOARD SUMMARY</h4>
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="mdi mdi-printer me-1"></i> พิมพ์ PDF
            </button>
            <a href="{{ route('dashboard.index.export') }}" class="btn btn-success">
                <i class="mdi mdi-file-excel me-1"></i> ดาวน์โหลดรายงาน (CSV)
            </a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
        @foreach($dashboardData as $data)
        <div class="col">
            <div class="card h-100 border-2 border-warning shadow-sm">
                <div class="card-header bg-label-warning text-center py-2">
                    <h4 class="mb-0 fw-bold text-dark">{{ $data->location_view ?: 'ไม่ระบุสถานที่' }}</h4>
                </div>
                <div class="card-body pt-3 text-sm">
                    <div class="d-flex justify-content-between border-bottom border-dotted mb-2 pb-1">
                        <span>จำนวนเรื่องที่รายงาน :</span>
                        <span class="fw-bold text-primary">{{ $data->total }} เรื่อง</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Unsafe Action :</span>
                        <span>{{ $data->unsafe_action }} เรื่อง</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Unsafe Condition :</span>
                        <span>{{ $data->unsafe_condition }} เรื่อง</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Life Saving Rule :</span>
                        <span>{{ $data->lsr_count }} เรื่อง</span>
                    </div>
                    <div class="d-flex justify-content-between mt-3 pt-2 border-top text-success fw-bold">
                        <span>ดำเนินการแก้ไขเรียบร้อย :</span>
                        <span>{{ $data->solved_count }} เรื่อง</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card p-4 shadow-sm border-2 border-primary">
                <h5 class="fw-bold text-primary mb-4 text-center">กราฟสรุปสถานะการแก้ไขราย Plant</h5>
                <div style="height: 400px;">
                    <canvas id="plantBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 border-top border-warning border-3">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered text-center sm-table">
                        <thead class="bg-condition">
                            <tr>
                                <th colspan="2" class="py-1">Unsafe Condition</th>
                            </tr>
                            <tr>
                                <th class="py-1">แก้ไขแล้ว</th>
                                <th class="py-1">รอการแก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold fs-5 text-success">{{ $conditionStats->solved ?? 0 }}</td>
                                <td class="fw-bold fs-5 text-danger">{{ $conditionStats->pending ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="height: 300px;">
                    <canvas id="conditionPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 border-top border-danger border-3">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered text-center sm-table">
                        <thead class="bg-action">
                            <tr>
                                <th colspan="2" class="py-1">Unsafe Action</th>
                            </tr>
                            <tr>
                                <th class="py-1">แก้ไขแล้ว</th>
                                <th class="py-1">รอการแก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold fs-5 text-success">{{ $actionStats->solved ?? 0 }}</td>
                                <td class="fw-bold fs-5 text-danger">{{ $actionStats->pending ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="height: 300px;">
                    <canvas id="actionPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

 



@section('custom-backend-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ลงทะเบียน Plugin สำหรับแสดงตัวเลขบนกราฟ
    Chart.register(ChartDataLabels);

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'right' },
            datalabels: {
                color: '#000',
                font: { weight: 'bold' },
                formatter: (value, ctx) => {
                    let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                    let percentage = sum > 0 ? (value * 100 / sum).toFixed(0) + "%" : "0%";
                    return value + ", " + percentage;
                }
            }
        }
    };

    // --- 1. กราฟ Unsafe Condition ---
    new Chart(document.getElementById('conditionPieChart'), {
        type: 'pie',
        data: {
            labels: ['แก้ไขแล้ว', 'รอการแก้ไข'],
            datasets: [{
                data: [{{ $conditionStats->solved ?? 0 }}, {{ $conditionStats->pending ?? 0 }}],
                backgroundColor: ['#10B981', '#06B6D4']
            }]
        },
        options: commonOptions
    });

    // --- 2. กราฟ Unsafe Action ---
    new Chart(document.getElementById('actionPieChart'), {
        type: 'pie',
        data: {
            labels: ['แก้ไขแล้ว', 'รอการแก้ไข'],
            datasets: [{
                data: [{{ $actionStats->solved ?? 0 }}, {{ $actionStats->pending ?? 0 }}],
                backgroundColor: ['#10B981', '#F97316']
            }]
        },
        options: commonOptions
    });

    // --- 3. กราฟแท่งราย Plant ---
    new Chart(document.getElementById('plantBarChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dashboardDataPie->pluck('location_view')) !!},
            datasets: [
                {
                    label: 'เรื่องที่รายงาน',
                    data: {!! json_encode($dashboardDataPie->pluck('total')) !!},
                    backgroundColor: '#1E40AF'
                },
                {
                    label: 'แก้ไขแล้ว',
                    data: {!! json_encode($dashboardDataPie->pluck('solved')) !!},
                    backgroundColor: '#10B981'
                },
                {
                    label: 'รอการแก้ไข',
                    data: {!! json_encode($dashboardDataPie->pluck('pending')) !!},
                    backgroundColor: '#F59E0B'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: { weight: 'bold' }
                }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection
