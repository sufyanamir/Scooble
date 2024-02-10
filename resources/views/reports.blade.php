@extends('layouts.main')

@section('main-section')
    <!-- partial -->
    <div class="content-wrapper py-0 my-2">
        <div style="border: none;">
            <div class="bg-white" style="border-radius: 20px;">
                <div class="p-3">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2 py-2">
                            <svg width="17" height="24" viewBox="0 0 17 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.09148 20.3718H7.52588V15.9374C5.19759 16.1948 3.34889 18.0435 3.09148 20.3718ZM8.64214 15.9374V20.3718H13.0765C12.8191 18.0435 10.9704 16.1948 8.64214 15.9374ZM13.0766 21.4881C12.9986 22.194 12.7746 22.855 12.4355 23.4412L13.4018 24.0001C13.9245 23.0965 14.2234 22.0473 14.2234 20.93C14.2234 17.5393 11.4747 14.7905 8.08401 14.7905C4.69332 14.7905 1.94458 17.5393 1.94458 20.93C1.94458 22.0473 2.24357 23.0965 2.76626 24.0001L3.73249 23.4412C3.39343 22.855 3.1694 22.194 3.09143 21.4881H13.0766Z"
                                    fill="white" />
                                <path
                                    d="M9.75845 20.9299C9.75845 21.8547 9.00883 22.6043 8.08406 22.6043C7.15929 22.6043 6.40967 21.8547 6.40967 20.9299C6.40967 20.0051 7.15929 19.2555 8.08406 19.2555C9.00883 19.2555 9.75845 20.0051 9.75845 20.9299Z"
                                    fill="white" />
                                <path
                                    d="M12.3171 19.169C12.1576 18.5735 12.511 17.9614 13.1064 17.8018L14.1847 17.5129C14.7802 17.3534 15.3923 17.7068 15.5518 18.3022L16.1297 20.4587C16.2892 21.0542 15.9358 21.6663 15.3403 21.8258L14.2621 22.1148C13.6666 22.2743 13.0545 21.9209 12.895 21.3254L12.3171 19.169Z"
                                    fill="white" />
                                <path
                                    d="M0.616123 18.3017C0.775693 17.7063 1.38779 17.3529 1.98326 17.5124L3.06152 17.8014C3.65699 17.9609 4.01039 18.573 3.85082 19.1685L3.27299 21.3249C3.11342 21.9204 2.50132 22.2738 1.90585 22.1143L0.827655 21.8253C0.232141 21.6658 -0.12125 21.0537 0.0383139 20.4582L0.616123 18.3017Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.06085 8.09285V6.41846H4.17711V8.09285C4.17711 10.2506 5.92629 11.9998 8.08403 11.9998C10.2418 11.9998 11.9909 10.2506 11.9909 8.09285V6.41846H13.1072V8.09285C13.1072 10.8671 10.8583 13.116 8.08403 13.116C5.30978 13.116 3.06085 10.8671 3.06085 8.09285Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.3879 4.74411H13.8045C13.8446 4.64169 13.888 4.52097 13.9311 4.38278L13.9379 4.36118C14.0884 3.87935 14.2234 3.44699 14.2234 2.5656C14.2234 2.11865 13.9331 1.74229 13.5487 1.44471C13.1592 1.14321 12.6273 0.885078 12.0349 0.674668C10.8484 0.253296 9.35203 0 8.08401 0C6.816 0 5.31965 0.253296 4.13318 0.674668C3.54072 0.885078 3.00882 1.14321 2.61936 1.44471C2.23498 1.74229 1.94458 2.11865 1.94458 2.5656C1.94458 3.38385 2.08143 3.8151 2.22203 4.25826C2.23514 4.29956 2.24826 4.34092 2.26132 4.38272C2.30446 4.52091 2.34777 4.64164 2.3879 4.74411ZM5.85149 3.06972C5.85149 2.76147 6.10137 2.51159 6.40962 2.51159H9.7584C10.0667 2.51159 10.3165 2.76147 10.3165 3.06972C10.3165 3.37796 10.0667 3.62785 9.7584 3.62785H6.40962C6.10137 3.62785 5.85149 3.37796 5.85149 3.06972Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.51468 6.08952C2.54002 5.9568 2.66152 5.86035 2.80334 5.86035H13.3647C13.5066 5.86035 13.6281 5.9568 13.6534 6.08952L13.6535 6.09019L13.6537 6.09086L13.654 6.09248L13.6546 6.09627L13.6562 6.10643C13.6574 6.1143 13.6588 6.1244 13.66 6.13651C13.6626 6.16079 13.6649 6.19339 13.6653 6.23307C13.666 6.31249 13.6586 6.42116 13.6286 6.54914C13.5677 6.80783 13.416 7.13668 13.0686 7.45627C12.3798 8.08986 10.9647 8.651 8.08404 8.651C5.20341 8.651 3.78827 8.08986 3.09948 7.45627C2.75205 7.13668 2.60035 6.80783 2.53951 6.54914C2.50943 6.42116 2.50212 6.31249 2.50279 6.23307C2.50312 6.19339 2.50547 6.16079 2.50803 6.13651C2.50932 6.1244 2.51066 6.1143 2.51183 6.10643L2.51345 6.09627L2.51412 6.09248L2.5144 6.09086L2.51456 6.09019L2.51468 6.08952Z"
                                    fill="white" />
                            </svg>
                        </span>
                        <span>@lang('lang.remember_me')</span>
                    </h3>
                    <hr>
                    <div class="px-2">
                        <div class="table-responsive">
                            <table id="drivers-table" class="display" style="width:100%">
                                <thead class="text-secondary" style="background-color: #E9EAEF;">
                                    <tr style="font-size: small;">
                                        <th></th>
                                        <th>Driver Name</th>
                                        <th>Trip No.</th>
                                        <th>Trip Name</th>
                                        <th>Optimize From</th>
                                    </tr>
                                </thead>
                                <tbody id="tableData">
                                    @foreach ($data as $data)
                                    <tr>
                                        <td>{{ date('M d, Y', strtotime($data['created_at']))}}</td>
                                        <td>{{$data['drivers']->name}}</td>
                                        <td>{{$data->trip_id}}</td>
                                        <td>{{$data['trips']->title}}</td>
                                        <td>{{$data->details}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var users_table = $('#drivers-table').DataTable();

        </script>
    @endsection