@extends('layouts.app') @section('styles') @endsection @section('content')
<h2 class="page-title">User Account
</h2>
<div class="row">
    <div class="col-lg-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-user"></i> Account Profile
                </h4>
            </header>
            <div class="body">
                <form id="user-form" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="{{ $action }}"
                    data-parsley-validate>
                    @csrf
                    @isset($method)
                        {{ $method }}
                    @endisset

                    @isset($user->email)
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-align-center">
                                <img class="img-circle" src="{{ empty($user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$user->profile_thumb) }}"
                                    alt="64x64" style="height: 112px;">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3 class="mt-sm mb-xs">{{ $user->name }}</h3>
                            <p>
                                e-mail: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                <br>
                                phone: {{ $user->phone }}
                                <br>
                                wallet: {{ $user->wallet[0]->address }}
                            </p>
                        </div>
                    </div>
                    @endisset
                    <fieldset>
                        <legend class="section">Personal Info</legend>
                        @include('layouts.partials.formErrors')
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="first_name">First Name
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" minlength="1" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="last_name">Last Name
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" minlength="1" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="dob">Day of Birth
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="dob" class="form-control input-transparent date-picker" type="text" name="dob" value="{{ old('dob', $user->dob) }}" required="required">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Email
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="phone">Phone Number
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        @empty($user->email)
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" value="{{ old('password', '') }}" required="required" class="form-control input-transparent"
                                    minlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password_confirmation">Confirm Password
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="password" id="password_confirmation" name="password_confirmation" required="required" data-parsley-equalto="#password"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="control-label col-sm-4">Country</label>
                            <div class="col-sm-6">
                                <select id="country" required="required"
                                        data-placeholder="Select country" class="select2 form-control" name="country">
                                    <option value=""></option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Helena">Saint Helena</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-leste">Timor-leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                        </div>
                        @endempty
                        @isset($user->email)
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="country">Country</label>
                            <div class="col-sm-6">
                                <input type="text" id="country" name="country" class="form-control input-transparent"
                                       disabled="disabled" value="{{ $user->country }}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password</label>
                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" value="{{ old('password', '') }}" class="form-control input-transparent"
                                    minlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password_confirmation">Confirm Password</label>
                            <div class="col-sm-6">
                                <input type="password" id="password_confirmation" name="password_confirmation" data-parsley-equalto="#password" class="form-control input-transparent">
                            </div>
                        </div>
                        @endisset
                        @if (Auth::user()->role->name == 'Administrator')
                        <div id="wrapper_whitepaper" class="form-group">
                            <label class="control-label col-sm-4" for="whitepaper">Whitepaper</label>
                            <div class="col-sm-6">
                                <input type="url" id="whitepaper" name="whitepaper" value="{{ old('whitepaper', $user->whitepaper) }}" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Role</label>
                            <div class="col-sm-8">
                                <div id="role" class="btn-group" data-toggle="buttons">
                                    @foreach ($roles as $role)
                                    <label class="btn {{ $user->role_id == $role->id ? 'btn-primary active' :  'btn-default' }}" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default">
                                        <input type="radio" name="role" value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'checked' : '' }} >{{ $role->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 mt-sm" for="locked">Locked</label>
                            <div class="col-sm-6">
                                <div class="checkbox-inline checkbox-ios">
                                    <label for="locked">
                                        <input type="checkbox" name="locked" id="locked" {{ $user->locked == 1 ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                    </fieldset>
                    <fieldset>
                        <legend class="section">Profile Picture</legend>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="image-crop">
                                    <img src="{{ empty($user->profile_picture) ? '' : asset('storage/'.$user->profile_picture) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Preview image</h4>
                                <div class="img-preview profile-pic-preview"></div>
                                <h4>Usage</h4>
                                <p>
                                    You can upload profile picture to crop container. It will saved as profile picture after save. Max filesize is <strong>8M</strong>.
                                </p>
                                <div class="btn-group">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input name="profile_picture" type="file" accept="image/*" id="inputImage" class="hide"> Upload photo
                                    </label>
                                    <input id="profile_thumb" name="profile_thumb" type="hidden">
                                </div>
                                <h4>Picture manipulation</h4>
                                <div class="btn-group">
                                    <button class="btn btn-default" id="zoomIn" type="button">Zoom In</button>
                                    <button class="btn btn-default" id="zoomOut" type="button">Zoom Out</button>
                                    <button class="btn btn-default" id="rotateLeft" type="button">Rotate Left</button>
                                    <button class="btn btn-default" id="rotateRight" type="button">Rotate Right</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                        <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
    @isset ($user->email)
    <div class="col-lg-6">
        <section class="widget">
            <header>
                <h5>Coin <span class="fw-semi-bold">Balances</span></h5>
                <div class="widget-controls">
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">Artist</th>
                            <th class="text-center">Coins you hold</th>
                            <th class="text-center">USD Value</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                    @foreach ($tokens as $item)
                        @if ($user->wallet[0]->getTokenBalance($item) > 0)
                        @php
                            $hasPortfolio_count = true;
                        @endphp
                        <tr class="clickable-row" data-href="{{ route('users.portfolio', $item) }}">
                            <td>{{ $item->user->name }}</td>
                            <td>{{ number_format($user->wallet[0]->getTokenBalance($item)) }} {{ $item->symbol }}</td>
                            <td>USD {{ number_format($user->wallet[0]->getTokenBalance($item) * $item->currentStage()->price / 100, 2) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    @if (empty($hasPortfolio_count))
                        <tr>
                            <td colspan="3" class="text-center">
                                No portfolios
                            </td>
                        </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="widget">
            <header>
                <h5>Transaction <span class="fw-semi-bold">History</span></h5>
                <div class="widget-controls">
                    <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Paid By</th>
                            <th>To</th>
                            <th>Value</th>
                            <th>Date</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                    @forelse ($transactions as $item)
                        <tr class="clickable-row" data-href="{{ route('tx.show', $item) }}">
                            <td>{{ $loop->index + 1}}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>
                            @if ($item->type->name == 'Withdraw')
                                {{ substr($item->to, 0, 8) }}...
                            @else
                                {{ $item->token->name }} / {{ $item->token->symbol }}
                            @endif
                            </td>
                            <td>
                            @if ($item->type->name == 'Ethereum')
                                ETH {{ round($item->eth_value, 2) }} / USD {{ number_format($item->usd_value / 100, 2) }}
                            @elseif ($item->type->name == 'Withdraw')
                                ETH {{ round($item->eth_value, 2) }}
                            @else
                                USD {{ number_format($item->usd_value / 100, 2) }}
                            @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td class="text-center">
                            @switch($item->status)
                                @case(0)
                                    <span class="badge bg-gray-lighter text-gray"><i class="glyphicon glyphicon-time"></i> Pending</span>
                                    @break
                                @case(1)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Confirmed</span>
                                    @break
                                @default
                                <span class="badge badge-danger"><i class="fa fa-ban"></i> Failed</span>
                            @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No transactions
                            </td>
                        </tr>
                    @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @endisset
</div>
@endsection @section('scripts')
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('lib/cropperjs/cropper.min.js') }}"></script>
<script src="{{ asset('lib/select2/select2.min.js') }}"></script>
<script src="{{ asset('lib/moment/moment.js') }}"></script>
<script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('lib/switchery/dist/switchery.min.js') }}"></script>

<!-- page specific scripts -->
<script src="{{ asset('js/pages/user-edit.js') }}"></script>
@endsection