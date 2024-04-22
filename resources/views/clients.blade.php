@extends('layouts.main')

@section('main-section')
<style>
  .custom-search-input {
  padding: 100px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
  /* Add any additional custom styles you want */
}
</style>
<!-- partial -->
  <div class="content-wrapper py-0 my-2">
    <div style="border: none;">
      <div class="bg-white" style="border-radius: 20px;">
        <div class="p-3">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2 py-2">
              <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.8576 5.98446C19.3853 5.98446 19.8684 5.71825 20.2227 5.28788C20.5987 4.83115 20.8314 4.1931 20.8314 3.48206C20.8314 2.73797 20.7572 2.07559 20.468 1.63218C20.205 1.22902 19.7172 0.979618 18.8576 0.979618C17.9981 0.979618 17.5102 1.22902 17.2473 1.63218C16.9581 2.07557 16.8839 2.73797 16.8839 3.48206C16.8839 4.19315 17.1165 4.83118 17.4926 5.28792C17.8469 5.71827 18.3299 5.98446 18.8576 5.98446ZM20.9765 5.90778C20.4392 6.5604 19.6904 6.96408 18.8576 6.96408C18.0248 6.96408 17.276 6.56041 16.7387 5.90781C16.2232 5.28162 15.9043 4.42355 15.9043 3.48206C15.9043 2.57365 16.0112 1.73985 16.4284 1.10029C16.8718 0.420497 17.6158 0 18.8576 0C20.0994 0 20.8434 0.420497 21.2868 1.10029C21.704 1.73984 21.811 2.57365 21.811 3.48206C21.811 4.42354 21.4921 5.28162 20.9765 5.90778Z" fill="white" />
                <path d="M23.0174 11.7404C22.9962 10.4001 22.9069 9.5513 22.5236 9.02564C22.1733 8.5453 21.5146 8.26609 20.3554 8.03867C20.0918 8.24402 19.5995 8.52014 18.8576 8.52014C18.1156 8.52014 17.6233 8.244 17.3597 8.03865C16.6132 8.18514 16.0743 8.35323 15.6915 8.58278C15.8194 8.20153 15.902 7.80454 15.9393 7.40337C16.353 7.25757 16.8421 7.13877 17.4224 7.03403L17.7077 6.98254L17.8892 7.20814C17.89 7.20908 18.1491 7.54052 18.8576 7.54052C19.566 7.54052 19.8251 7.20908 19.8259 7.20814L20.0075 6.98254L20.2927 7.03403C21.8634 7.31755 22.7665 7.70391 23.3119 8.45166C23.8472 9.18565 23.9688 10.1865 23.9932 11.7251L23.9942 11.7924C23.9971 11.9705 24 12.1469 24 12.1559L23.9426 12.3836C23.9401 12.3883 23.1231 14.0266 18.8576 14.0266C18.7048 14.0266 18.5568 14.0243 18.4126 14.0202C18.3449 13.6778 18.2519 13.3442 18.1236 13.0309C18.3533 13.0413 18.5975 13.047 18.8576 13.047C21.9203 13.047 22.809 12.2702 23.0202 12.0112C23.0199 11.8958 23.0192 11.8524 23.0185 11.8077L23.0174 11.7404Z" fill="white" />
                <path d="M12.0007 9.68808C12.6715 9.68808 13.2843 9.35136 13.7325 8.80697C14.2024 8.23625 14.493 7.44074 14.493 6.5557C14.493 5.63766 14.3998 4.81782 14.0362 4.26041C13.6989 3.74324 13.0814 3.42333 12.0007 3.42333C10.9199 3.42333 10.3024 3.74324 9.96507 4.26041C9.6015 4.8178 9.50831 5.63764 9.50831 6.5557C9.50831 7.44075 9.79897 8.2363 10.2689 8.80702C10.717 9.35137 11.3297 9.68808 12.0007 9.68808ZM14.4863 9.42687C13.8551 10.1935 12.9766 10.6677 12.0007 10.6677C11.0246 10.6677 10.1462 10.1935 9.51503 9.42692C8.90565 8.68673 8.52869 7.67116 8.52869 6.55571C8.52869 5.47336 8.65467 4.4821 9.1462 3.72854C9.66394 2.93473 10.5376 2.44373 12.0006 2.44373C13.4636 2.44373 14.3372 2.93473 14.8551 3.72854C15.3466 4.48208 15.4726 5.47336 15.4726 6.55571C15.4726 7.67117 15.0957 8.6867 14.4863 9.42687Z" fill="white" />
                <path d="M17.1387 16.4788C17.1127 14.8356 17.0013 13.792 16.5213 13.1338C16.0751 12.5221 15.2464 12.1721 13.7873 11.8897C13.4934 12.1291 12.9085 12.4792 12.0005 12.4792C11.0924 12.4792 10.5075 12.1291 10.2136 11.8897C8.77045 12.169 7.94372 12.5148 7.49424 13.1148C7.01302 13.7571 6.89407 14.7715 6.86427 16.3656L6.86315 16.4248C6.86097 16.5402 6.859 16.6444 6.85836 16.8421C7.09453 17.1482 8.16716 18.1653 12.0005 18.1653C15.8339 18.1653 16.9065 17.1481 17.1426 16.842C17.1422 16.6944 17.1411 16.629 17.1401 16.5635L17.1387 16.4788L17.1387 16.4788ZM17.3095 12.5598C17.9415 13.4264 18.0854 14.6219 18.1145 16.4635L18.1159 16.5482C18.1192 16.7505 18.1224 16.9483 18.1224 16.9834L18.065 17.2111C18.0621 17.2166 17.1008 19.1449 12.0005 19.1449C6.90013 19.1449 5.93886 17.2166 5.93596 17.2111L5.87854 16.9834C5.87854 16.8746 5.88268 16.6571 5.88738 16.4095L5.8885 16.3503C5.92211 14.5513 6.0764 13.3799 6.71364 12.5293C7.35823 11.6689 8.42912 11.2188 10.2813 10.8844L10.5659 10.833L10.7481 11.0585C10.7491 11.0598 11.0931 11.4995 12.0005 11.4995C12.9078 11.4995 13.2518 11.0598 13.2528 11.0585L13.435 10.833L13.7196 10.8844C15.5932 11.2226 16.6675 11.6794 17.3095 12.5598Z" fill="white" />
                <path d="M5.14237 5.98446C4.61469 5.98446 4.13162 5.71825 3.77729 5.28788C3.40127 4.83115 3.16864 4.1931 3.16864 3.48206C3.16864 2.73797 3.24281 2.07559 3.53204 1.63218C3.79503 1.22902 4.28284 0.979618 5.14237 0.979618C6.00195 0.979618 6.48977 1.22902 6.75274 1.63218C7.04193 2.07557 7.11607 2.73797 7.11607 3.48206C7.11607 4.19315 6.88346 4.83118 6.50744 5.28792C6.15313 5.71827 5.67009 5.98446 5.14237 5.98446ZM3.02347 5.90778C3.56079 6.5604 4.3096 6.96408 5.14237 6.96408C5.97517 6.96408 6.72396 6.56041 7.26127 5.90781C7.7768 5.28162 8.0957 4.42355 8.0957 3.48206C8.0957 2.57365 7.98877 1.73985 7.57162 1.10029C7.1282 0.420497 6.38419 0 5.14237 0C3.90062 0 3.15662 0.420497 2.71318 1.10029C2.29599 1.73984 2.18903 2.57365 2.18903 3.48206C2.18903 4.42354 2.50793 5.28162 3.02347 5.90778Z" fill="white" />
                <path d="M0.982648 11.7404C1.00385 10.4001 1.09307 9.5513 1.47643 9.02564C1.82673 8.5453 2.48539 8.26609 3.64459 8.03867C3.90819 8.24402 4.40047 8.52014 5.14238 8.52014C5.88438 8.52014 6.37671 8.244 6.64031 8.03865C7.38683 8.18514 7.92575 8.35323 8.30848 8.58278C8.18059 8.20153 8.09799 7.80454 8.06068 7.40337C7.64704 7.25757 7.15791 7.13877 6.57761 7.03403L6.29235 6.98254L6.11076 7.20814C6.11 7.20908 5.85092 7.54052 5.14237 7.54052C4.43396 7.54052 4.17487 7.20908 4.17411 7.20814L3.99253 6.98254L3.70726 7.03403C2.13658 7.31755 1.23347 7.70391 0.688143 8.45166C0.15285 9.18565 0.0311854 10.1865 0.00685173 11.7251L0.00576688 11.7924C0.00287438 11.9705 0 12.1469 0 12.1559L0.0574159 12.3836C0.0598745 12.3883 0.876932 14.0266 5.14236 14.0266C5.29525 14.0266 5.4432 14.0243 5.58736 14.0202C5.65512 13.6778 5.74807 13.3442 5.87641 13.0309C5.64669 13.0413 5.40255 13.047 5.14237 13.047C2.07971 13.047 1.19102 12.2702 0.979779 12.0112C0.980104 11.8958 0.980827 11.8524 0.98155 11.8077L0.982648 11.7404Z" fill="white" />
              </svg>
            </span>
            <span>@lang('lang.clients')</span>
          </h3>
          <div class="row mb-2">
            <!-- <div class="col-lg-4"></div> -->
            <div class="col-lg-12">
              <div class="row mx-1">
                <div class="col-lg-9 col-sm-6 mb-1 pr-0" style="text-align: right;">
                  <button class="btn add-btn text-white" data-toggle="modal" data-target="#addclient" style="background-color: #E45F00;"><span><i class="fa fa-plus"></i> @lang('lang.add_client')</span></button>
                </div>
                <div class="col-lg-3 col-sm-6 pr-0">
                  <div class="input-group">
                    <div class="input-group-prepend d-none d-md-block d-sm-block d-lg-block">
                      <div class="input-group-text bg-white" style="border-right: none; border: 1px solid #DDDDDD;">
                        <svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.56221 14.0648C7.58971 14.3147 7.52097 14.5814 7.36287 14.7563C7.29927 14.8336 7.22373 14.8949 7.14058 14.9367C7.05742 14.9785 6.96827 15 6.87825 15C6.78822 15 6.69907 14.9785 6.61592 14.9367C6.53276 14.8949 6.45722 14.8336 6.39363 14.7563L3.63713 11.4151C3.56216 11.3263 3.50516 11.2176 3.47057 11.0977C3.43599 10.9777 3.42477 10.8496 3.43779 10.7235V6.45746L0.145116 1.34982C0.0334875 1.17612 -0.0168817 0.955919 0.005015 0.737342C0.0269117 0.518764 0.119294 0.319579 0.261975 0.183308C0.392582 0.0666576 0.536937 0 0.688166 0H10.3118C10.4631 0 10.6074 0.0666576 10.738 0.183308C10.8807 0.319579 10.9731 0.518764 10.995 0.737342C11.0169 0.955919 10.9665 1.17612 10.8549 1.34982L7.56221 6.45746V14.0648ZM2.09047 1.66644L4.81259 5.88254V10.4819L6.1874 12.1484V5.8742L8.90953 1.66644H2.09047Z" fill="#323C47" />
                        </svg>
                      </div>
                    </div>
                    <select name="filter_by_sts" id="filter_by_sts_client" class="form-select select-group">
                      <option value="">
                        @lang('lang.filter_by_status')
                      </option>
                      @foreach(config('constants.STATUS_OPTIONS_' . app()->getLocale()) as $key => $value)
                        <option value="{{$value}}">{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- <div class="col-lg-4 px-1">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-white" style="border-right: none; border: 1px solid #DDDDDD;">
                        <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M13.6752 0.558058C13.4311 0.313981 13.0354 0.313981 12.7913 0.558058L8.81386 4.53553C8.56978 4.77961 8.56978 5.17534 8.81386 5.41942C9.05794 5.6635 9.45366 5.6635 9.69774 5.41942L13.2333 1.88388L16.7688 5.41942C17.0129 5.6635 17.4086 5.6635 17.6527 5.41942C17.8968 5.17534 17.8968 4.77961 17.6527 4.53553L13.6752 0.558058ZM12.6083 14C12.6083 14.3452 12.8881 14.625 13.2333 14.625C13.5785 14.625 13.8583 14.3452 13.8583 14H12.6083ZM12.6083 1V14H13.8583V1H12.6083Z" fill="#323C47" />
                          <path d="M5.625 1C5.625 0.654822 5.34518 0.375 5 0.375C4.65482 0.375 4.375 0.654822 4.375 1H5.625ZM4.55806 14.4419C4.80214 14.686 5.19786 14.686 5.44194 14.4419L9.41942 10.4645C9.6635 10.2204 9.6635 9.82466 9.41942 9.58058C9.17534 9.3365 8.77961 9.3365 8.53553 9.58058L5 13.1161L1.46447 9.58058C1.22039 9.3365 0.82466 9.3365 0.580583 9.58058C0.336505 9.82466 0.336505 10.2204 0.580583 10.4645L4.55806 14.4419ZM4.375 1V14H5.625V1H4.375Z" fill="#323C47" />
                        </svg>
                      </div>
                    </div>
                    <select name="sort_by" id="sort_by" class="form-select" style="border-left: none;">
                      <option value="">
                        @lang('lang.sort_by')
                      </option>
                    </select>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          <hr>
          <div class="px-2">
              <div class="table-responsive">
                <table id="users-table" class="display" style="width:100%">
                  <thead class="text-secondary" style="background-color: #E9EAEF;">
                    <tr style="font-size: small;">
                      <th>#</th>
                      <th> @lang('lang.joining_date') </th>
                      <th></th>
                      <th> @lang('lang.name') </th>
                      <th> @lang('lang.email') </th>
                      <th></th>
                      <th> @lang('lang.company_name') </th>
                      <th> @lang('lang.packages') </th>
                      <th> @lang('lang.expiry_date') </th>
                      <th> @lang('lang.status') </th>
                      <th>@lang('lang.actions')</th>
                    </tr>
                  </thead>
                  <tbody id="tableData">

                    @foreach($data as $key => $value)
                    <tr style="font-size: small;">
                      <td>{{++$key}}</td>
                      <td>{{table_date($value['created_at'])}}</td>
                      <td><img src="{{ (isset($value['user_pic'])) ? asset('storage/' . $value['user_pic']) : 'assets/images/user.png'}}" style="width: 45px; height: 45px; border-radius: 38px; object-fit: cover;" alt="text"></td>
                      <td> {{ $value['name'] }} </td>
                      <td>{{ $value['email'] }}</td>
                      <td><img src="{{ (isset($value['com_pic'])) ? asset('storage/' . $value['com_pic']) : 'assets/images/user.png'}}" style="width: 45px; height: 45px; border-radius: 38px; object-fit: cover;" alt="text"></td>
                      <td> {{ $value['com_name'] }}</td>
                      <td>{{ $value['package']['title'] ?? 'No Subscription' }}</td>
                      <td>{{ $value['sub_exp_date'] }}</td>
                      @if($value['status'] == 1)
                      <td>
                        <button class="btn btn_status">
                          <span data-client_id="{{$value['id']}}" data-status="{{$value['status']}}"> 
                            <div style="width: 100%; height: 100%; padding-top: 5px; padding-bottom: 5px; padding-left: 19px; padding-right: 20px; background: rgba(48.62, 165.75, 19.34, 0.18); border-radius: 3px; justify-content: center; align-items: center; display: inline-flex">
                              <div style="color: #31A613; font-size: 14px; font-weight: 500; word-wrap: break-word">@lang('lang.active')</div>
                            </div>
                          </span>
                        </button>
                      </td>
                      @elseif($value['status'] == 2)
                      <td>
                        <button class="btn btn_status">
                          <span data-client_id="{{$value['id']}}" data-status="{{$value['status']}}"> 
                          <div style="width: 100%; height: 100%; padding-top: 6px; padding-bottom: 4px; padding-left: 15px; padding-right: 13px; background: rgba(77, 77, 77, 0.12); border-radius: 3px; justify-content: center; align-items: center; display: inline-flex">
                            <div style="text-align: center; color: #8F9090; font-size: 14px; font-weight: 500; word-wrap: break-word">@lang('lang.pending')</div>
                          </div>
                        </span>
                        </button>
                      </td>
                      @elseif($value['status'] == 5)
                      <td>
                        <button class="btn btn_status">
                          <span data-client_id="{{$value['id']}}" data-status="{{$value['status']}}">
                          <div style="width: 100%; height: 100%; padding-top: 6px; padding-bottom: 7px; padding-left: 14px; padding-right: 12px;    background: rgba(245, 34, 45, 0.19); border-radius: 3px; justify-content: center; align-items: center; display: inline-flex">
                            <div style="text-align: center; color: #F5222D; font-size: 14px; font-weight: 500; word-wrap: break-word">@lang('lang.deleted')</div>
                        </div> 
                        </span>
                        </button>
                      </td>

                      @else
                      <td>
                        <button class="btn btn_status">
                          <span data-client_id="{{$value['id']}}" data-status="{{$value['status']}}">
                          <div style="width: 100%; height: 100%; padding-top: 6px; padding-bottom: 7px; padding-left: 14px; padding-right: 12px;    background: rgba(245, 34, 45, 0.19); border-radius: 3px; justify-content: center; align-items: center; display: inline-flex">
                            <div style="text-align: center; color: #F5222D; font-size: 14px; font-weight: 500; word-wrap: break-word">@lang('lang.suspend')</div>
                        </div> 
                        </span>
                        </button>
                      </td>
                      @endif

                      <td style="min-width: 80px; max-width: fit-content;">
                      @if($value['status'] != 5)
                        <button id="btn_edit_client" class="btn p-0" data-client_id="{{$value['id']}}" data-api_name ="{{'users'}}">
                          <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle opacity="0.1" cx="18" cy="18" r="18" fill="#233A85" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1634 23.6195L22.3139 15.6658C22.6482 15.2368 22.767 14.741 22.6556 14.236C22.559 13.777 22.2768 13.3406 21.8534 13.0095L20.8208 12.1893C19.922 11.4744 18.8078 11.5497 18.169 12.3699L17.4782 13.2661C17.3891 13.3782 17.4114 13.5438 17.5228 13.6341C17.5228 13.6341 19.2684 15.0337 19.3055 15.0638C19.4244 15.1766 19.5135 15.3271 19.5358 15.5077C19.5729 15.8614 19.3278 16.1925 18.9638 16.2376C18.793 16.2602 18.6296 16.2075 18.5107 16.1097L16.676 14.6499C16.5868 14.5829 16.4531 14.5972 16.3788 14.6875L12.0185 20.3311C11.7363 20.6848 11.6397 21.1438 11.7363 21.5878L12.2934 24.0032C12.3231 24.1312 12.4345 24.2215 12.5682 24.2215L15.0195 24.1914C15.4652 24.1838 15.8812 23.9807 16.1634 23.6195ZM19.5955 22.8673H23.5925C23.9825 22.8673 24.2997 23.1886 24.2997 23.5837C24.2997 23.9795 23.9825 24.3 23.5925 24.3H19.5955C19.2055 24.3 18.8883 23.9795 18.8883 23.5837C18.8883 23.1886 19.2055 22.8673 19.5955 22.8673Z" fill="#233A85" />
                          </svg>
                        </button>
                        <button id="btn_dell_user" class="btn p-0" data-id="{{$value['id']}}" >
                          <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle opacity="0.1" cx="18" cy="18" r="18" fill="#DF6F79" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.4909 13.743C23.7359 13.743 23.94 13.9465 23.94 14.2054V14.4448C23.94 14.6975 23.7359 14.9072 23.4909 14.9072H13.0497C12.804 14.9072 12.6 14.6975 12.6 14.4448V14.2054C12.6 13.9465 12.804 13.743 13.0497 13.743H14.8866C15.2597 13.743 15.5845 13.4778 15.6684 13.1036L15.7646 12.6739C15.9141 12.0887 16.4061 11.7 16.9692 11.7H19.5708C20.1277 11.7 20.6252 12.0887 20.7692 12.6431L20.8721 13.1029C20.9555 13.4778 21.2802 13.743 21.654 13.743H23.4909ZM22.5577 22.4943C22.7495 20.707 23.0852 16.4609 23.0852 16.418C23.0975 16.2883 23.0552 16.1654 22.9713 16.0665C22.8812 15.9739 22.7672 15.9191 22.6416 15.9191H13.9032C13.777 15.9191 13.6569 15.9739 13.5735 16.0665C13.489 16.1654 13.4473 16.2883 13.4534 16.418C13.4546 16.4259 13.4666 16.5755 13.4868 16.8255C13.5762 17.9364 13.8255 21.0303 13.9865 22.4943C14.1005 23.5729 14.8081 24.2507 15.8332 24.2753C16.6242 24.2936 17.4391 24.2999 18.2724 24.2999C19.0573 24.2999 19.8544 24.2936 20.6699 24.2753C21.7305 24.257 22.4376 23.5911 22.5577 22.4943Z" fill="#D11A2A" />
                          </svg>
                        </button>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->

  <!-- Add Client Modal -->
  @php
  $login_userId = $user->id;
  $user_role_static = user_roles('2');
  @endphp

  @include('usermodal')
  <!-- <div class="modal fade" style="height: 30rem;" id="addclient" tabindex="-1" aria-labelledby="addclientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-white">
        <div class="modal-header pb-0" style="border-bottom: none;">
          <h4>
            <svg width="30" height="30" viewBox="0 0 40 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M31.4294 9.97411C32.3088 9.97411 33.1139 9.53041 33.7045 8.81313C34.3312 8.05192 34.7189 6.98851 34.7189 5.80344C34.7189 4.56328 34.5953 3.45931 34.1132 2.7203C33.6749 2.04837 32.8619 1.6327 31.4294 1.6327C29.9967 1.6327 29.1837 2.04837 28.7454 2.7203C28.2634 3.45928 28.1399 4.56327 28.1399 5.80344C28.1399 6.98858 28.5275 8.05196 29.1542 8.81321C29.7448 9.53046 30.5498 9.97411 31.4294 9.97411ZM34.9609 9.84629C34.0653 10.934 32.8173 11.6068 31.4294 11.6068C30.0414 11.6068 28.7934 10.934 27.8979 9.84635C27.0386 8.8027 26.5071 7.37258 26.5071 5.80343C26.5071 4.28941 26.6854 2.89975 27.3806 1.83381C28.1196 0.700828 29.3597 0 31.4294 0C33.4989 0 34.739 0.700828 35.478 1.83381C36.1733 2.89973 36.3516 4.28942 36.3516 5.80343C36.3516 7.37257 35.8201 8.8027 34.9609 9.84629Z" fill="#452C88" />
              <path d="M38.3622 19.5672C38.3269 17.3334 38.1782 15.9187 37.5393 15.0426C36.9554 14.2421 35.8577 13.7767 33.9257 13.3977C33.4863 13.7399 32.6659 14.2001 31.4294 14.2001C30.1927 14.2001 29.3721 13.7399 28.9328 13.3976C27.6886 13.6418 26.7904 13.9219 26.1525 14.3045C26.3657 13.6691 26.5033 13.0074 26.5655 12.3388C27.2549 12.0958 28.0701 11.8978 29.0373 11.7233L29.5127 11.6375L29.8154 12.0134C29.8167 12.015 30.2485 12.5674 31.4294 12.5674C32.6101 12.5674 33.0419 12.015 33.0431 12.0134L33.3458 11.6375L33.8212 11.7233C36.439 12.1958 37.9442 12.8397 38.8531 14.086C39.7452 15.3093 39.948 16.9773 39.9886 19.5417L39.9904 19.654C39.9952 19.9508 40 20.2447 40 20.2597L39.9043 20.6391C39.9002 20.647 38.5384 23.3776 31.4294 23.3776C31.1746 23.3776 30.928 23.3737 30.6877 23.3669C30.5748 22.7961 30.4199 22.2403 30.206 21.718C30.5888 21.7353 30.9957 21.7449 31.4294 21.7449C36.5338 21.7449 38.015 20.4502 38.367 20.0186C38.3665 19.8262 38.3653 19.7538 38.3641 19.6795L38.3622 19.5672Z" fill="#452C88" />
              <path d="M20.0011 16.1469C21.1192 16.1469 22.1405 15.5857 22.8874 14.6784C23.6706 13.7272 24.1551 12.4014 24.1551 10.9263C24.1551 9.39622 23.9997 8.02982 23.3937 7.10081C22.8314 6.23885 21.8023 5.70567 20.0011 5.70567C18.1998 5.70567 17.1706 6.23885 16.6085 7.10081C16.0025 8.02979 15.8472 9.39619 15.8472 10.9263C15.8472 12.4014 16.3316 13.7273 17.1148 14.6785C17.8617 15.5857 18.8829 16.1469 20.0011 16.1469ZM24.1438 15.7116C23.0918 16.9893 21.6277 17.7796 20.0011 17.7796C18.3744 17.7796 16.9103 16.9893 15.8584 15.7117C14.8428 14.478 14.2145 12.7854 14.2145 10.9263C14.2145 9.12239 14.4245 7.47029 15.2437 6.21435C16.1066 4.89133 17.5627 4.073 20.0011 4.073C22.4393 4.073 23.8954 4.89133 24.7584 6.21435C25.5777 7.47026 25.7877 9.12238 25.7877 10.9263C25.7877 12.7854 25.1595 14.4779 24.1438 15.7116Z" fill="#452C88" />
              <path d="M28.5646 27.4648C28.5212 24.726 28.3356 22.9868 27.5355 21.8897C26.7919 20.8701 25.4106 20.2868 22.979 19.8162C22.4891 20.2153 21.5143 20.7986 20.0009 20.7986C18.4874 20.7986 17.5125 20.2153 17.0227 19.8162C14.6175 20.2818 13.2396 20.8581 12.4904 21.858C11.6884 22.9285 11.4902 24.6191 11.4405 27.276L11.4386 27.3747C11.435 27.5671 11.4317 27.7407 11.4306 28.0702C11.8243 28.5803 13.612 30.2755 20.0009 30.2755C26.3899 30.2755 28.1775 28.5802 28.571 28.0701C28.5703 27.8241 28.5686 27.715 28.5668 27.6058L28.5646 27.4648L28.5646 27.4648ZM28.8493 20.933C29.9026 22.3774 30.1423 24.3699 30.1909 27.4393L30.1932 27.5804C30.1987 27.9175 30.204 28.2472 30.204 28.3058L30.1084 28.6852C30.1035 28.6944 28.5013 31.9082 20.0009 31.9082C11.5003 31.9082 9.89815 28.6944 9.8933 28.6852L9.79761 28.3058C9.79761 28.1243 9.80451 27.7619 9.81234 27.3492L9.81421 27.2505C9.87022 24.2522 10.1274 22.2998 11.1894 20.8822C12.2638 19.4482 14.0486 18.698 17.1355 18.1407L17.6099 18.0551L17.9136 18.4309C17.9152 18.433 18.4885 19.166 20.0009 19.166C21.5131 19.166 22.0864 18.433 22.088 18.4309L22.3917 18.0551L22.8661 18.1407C25.9887 18.7044 27.7792 19.4658 28.8493 20.933Z" fill="#452C88" />
              <path d="M8.57067 9.97411C7.69121 9.97411 6.8861 9.53041 6.29555 8.81313C5.66884 8.05192 5.28112 6.98851 5.28112 5.80344C5.28112 4.56328 5.40475 3.45931 5.8868 2.7203C6.3251 2.04837 7.13813 1.6327 8.57067 1.6327C10.0033 1.6327 10.8163 2.04837 11.2546 2.7203C11.7366 3.45928 11.8602 4.56327 11.8602 5.80344C11.8602 6.98858 11.4725 8.05196 10.8458 8.81321C10.2553 9.53046 9.4502 9.97411 8.57067 9.97411ZM5.03917 9.84629C5.9347 10.934 7.18272 11.6068 8.57067 11.6068C9.95868 11.6068 11.2067 10.934 12.1022 9.84635C12.9614 8.8027 13.4929 7.37258 13.4929 5.80343C13.4929 4.28941 13.3147 2.89975 12.6194 1.83381C11.8804 0.700828 10.6404 0 8.57067 0C6.50109 0 5.26109 0.700828 4.52203 1.83381C3.82672 2.89973 3.64844 4.28942 3.64844 5.80343C3.64844 7.37257 4.17995 8.8027 5.03917 9.84629Z" fill="#452C88" />
              <path d="M1.63775 19.5672C1.67309 17.3334 1.82178 15.9187 2.46072 15.0426C3.04455 14.2421 4.14232 13.7767 6.07432 13.3977C6.51365 13.7399 7.33412 14.2001 8.57063 14.2001C9.80729 14.2001 10.6279 13.7399 11.0672 13.3976C12.3114 13.6418 13.2096 13.9219 13.8475 14.3045C13.6343 13.6691 13.4967 13.0074 13.4345 12.3388C12.7451 12.0958 11.9299 11.8978 10.9627 11.7233L10.4873 11.6375L10.1846 12.0134C10.1833 12.015 9.75154 12.5674 8.57061 12.5674C7.38994 12.5674 6.95811 12.015 6.95684 12.0134L6.65422 11.6375L6.17876 11.7233C3.56096 12.1958 2.05578 12.8397 1.14691 14.086C0.254751 15.3093 0.0519756 16.9773 0.0114196 19.5417L0.00961147 19.654C0.00479063 19.9508 0 20.2447 0 20.2597L0.0956931 20.6391C0.0997908 20.647 1.46155 23.3776 8.57061 23.3776C8.82542 23.3776 9.072 23.3737 9.31226 23.3669C9.42519 22.7961 9.58012 22.2403 9.79402 21.718C9.41115 21.7353 9.00424 21.7449 8.57061 21.7449C3.46618 21.7449 1.98503 20.4502 1.63296 20.0186C1.63351 19.8262 1.63471 19.7538 1.63592 19.6795L1.63775 19.5672Z" fill="#452C88" />
            </svg>
            Add Client
          </h4>
          <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="userStore" id="formData" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="role" name="role" value="Client">
          <input type="hidden" id="client_id" name="id">

          <div class="modal-body pt-0">
            <div class="row">
              <div class="col-lg-6 mb-2">
                <label for="user_pic">Upload Image</label>
                <input type="file" name="user_pic" id="user_pic" class="form-control">
              </div>
              <div class="col-lg-6 mb-2">
                <label for="com_pic">Company Logo</label>
                <input type="file" name="com_pic" id="com_pic" class="form-control">
              </div>
              <div class="col-lg-6 mt-2">
                <label for="name">Name</label>
                <input type="text" required name="name" id="name" class="form-control">
              </div>
              <div class="col-lg-6 mt-2">
                <label for="email">E-mail</label>
                <input type="email" required name="email" id="email" class="form-control">
              </div>
              <div class="col-lg-6 mt-2">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" id="phone" class="form-control">
              </div>
              <div class="col-lg-6 mt-2">
                <label for="com_name">Company Name</label>
                <input type="text" name="com_name" id="com_name" class="form-control">
              </div>
              <div class="col-lg-6 mt-2">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control">
              </div>
              <div class="col-lg-6 mt-3">
                <div class="row py-4">
                  <div class="col-lg-6">
                    <button type="button" class="btn btn-sm btn-outline px-5" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #ffffff; border: 1px solid #D0D5DD; border-radius: 8px; width: 100%;">@lang('lang.cancel')</button>
                  </div>
                  <div class="col-lg-6">
                    <button type="submit" id="btn_save" class="btn btn-sm text-white px-5" data-target="#add" style="background-color: #E45F00; border-radius: 8px; width: 100%;">
                      <div class="spinner-border spinner-border-sm text-white d-none" id="spinner"></div>
                    <span id="add_btn">@lang('lang.add')</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> -->
  <!-- Add Client Modal End -->

  <!-- Add Button Modal -->
  <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-white">
        <div class="modal-header" style="border: none;">
          <h5 class="modal-title" id="addLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="4" width="48" height="48" rx="24" fill="#D1FADF" />
            <path d="M37.75 16H18.25C17.0073 16 16 17.3431 16 19V37C16 38.6569 17.0073 40 18.25 40H37.75C38.9927 40 40 38.6569 40 37V19C40 17.3431 38.9927 16 37.75 16ZM37.75 19V21.5503C36.699 22.6915 35.0234 24.466 31.4412 28.2059C30.6518 29.0339 29.0881 31.0229 28 30.9998C26.9121 31.0232 25.3479 29.0336 24.5588 28.2059C20.9772 24.4666 19.3012 22.6917 18.25 21.5503V19H37.75ZM18.25 37V25.3999C19.3241 26.5406 20.8473 28.1413 23.169 30.5653C24.1935 31.6406 25.9877 34.0144 28 33.9999C30.0024 34.0144 31.7739 31.675 32.8306 30.5658C35.1522 28.1418 36.6759 26.5407 37.75 25.3999V37H18.25Z" fill="#0F771A" />
            <rect x="4" y="4" width="48" height="48" rx="24" stroke="#ECFDF3" stroke-width="8" />
          </svg>
          <h5 class="mt-3"> @lang('lang.email_sent_with_status') </h5>
        </div>
        <div class="modal-footer" style="border: none;">
          <button class="btn btn-sm text-white px-5" style="background-color: #233A85; border-radius: 8px;"> @lang('lang.ok')</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Button Modal End -->

  <!-- Delete Client Modal -->
  <div class="modal fade" id="deleteclient" tabindex="-1" aria-labelledby="deleteclientLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-white">
        
      </div>
    </div>
  </div>
  <!-- Delete Client Modal End -->

  @endsection