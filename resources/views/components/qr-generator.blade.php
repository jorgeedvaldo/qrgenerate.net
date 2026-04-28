{{-- QR Code Generator Component
     Props:
     - type (string): url, wifi, whatsapp, vcard, email, sms, phone, location
     - locale (string): en, pt
--}}
@php
    $type = $type ?? 'url';
    $locale = $locale ?? 'en';
    $isPt = $locale === 'pt';
@endphp

<div class="row" id="qr-generator-component">
    <input type="hidden" id="qr-type-val" value="{{ $type }}">
    
    {{-- Left Column: Settings --}}
    <div class="col-md-6">
        <div class="panel panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> {{ $isPt ? 'Configuração do QR Code' : 'QR Code Configuration' }}</h3>
            </div>
            <div class="panel-body">

                {{-- Dynamic Forms Wrapper --}}
                <div id="qr-dynamic-form">
                    
                    @if(in_array($type, ['url', 'instagram', 'restaurant-menu', 'pdf', 'event']))
                        <div class="form-group">
                            <label for="qr-text">URL / {{ $isPt ? 'Texto' : 'Text' }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="qr-text" placeholder="https://www.example.com">
                        </div>
                    @endif

                    @if($type === 'wifi')
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="wifi-ssid">{{ $isPt ? 'Nome da Rede (SSID)' : 'Network Name (SSID)' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="wifi-ssid" placeholder="MyWiFiNetwork">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="wifi-password">Password</label>
                                <input type="text" class="form-control" id="wifi-password" placeholder="********">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="wifi-encryption">{{ $isPt ? 'Segurança' : 'Encryption' }}</label>
                                <select class="form-control" id="wifi-encryption">
                                    <option value="WPA">WPA/WPA2/WPA3</option>
                                    <option value="WEP">WEP</option>
                                    <option value="nopass">{{ $isPt ? 'Sem Password' : 'None' }}</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group" style="padding-top: 25px;">
                                <label>
                                    <input type="checkbox" id="wifi-hidden"> {{ $isPt ? 'Rede Oculta' : 'Hidden Network' }}
                                </label>
                            </div>
                        </div>
                    @endif

                    @if($type === 'whatsapp')
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="wa-code">{{ $isPt ? 'Indicativo' : 'Country Code' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="wa-code" placeholder="e.g. 1 or 351">
                            </div>
                            <div class="col-sm-8 form-group">
                                <label for="wa-phone">{{ $isPt ? 'Número de Telefone' : 'Phone Number' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="wa-phone" placeholder="123456789">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wa-message">{{ $isPt ? 'Mensagem Inicial (Opcional)' : 'Initial Message (Optional)' }}</label>
                            <textarea class="form-control" id="wa-message" rows="2" placeholder="{{ $isPt ? 'Olá, gostaria de saber mais...' : 'Hello, I would like to know more...' }}"></textarea>
                        </div>
                    @endif

                    @if($type === 'vcard')
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="vcard-fname">{{ $isPt ? 'Nome' : 'First Name' }}</label>
                                <input type="text" class="form-control" id="vcard-fname">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="vcard-lname">{{ $isPt ? 'Apelido' : 'Last Name' }}</label>
                                <input type="text" class="form-control" id="vcard-lname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="vcard-phone">{{ $isPt ? 'Telemóvel' : 'Mobile Phone' }}</label>
                                <input type="text" class="form-control" id="vcard-phone">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="vcard-email">Email</label>
                                <input type="email" class="form-control" id="vcard-email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="vcard-company">{{ $isPt ? 'Empresa' : 'Company' }}</label>
                                <input type="text" class="form-control" id="vcard-company">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="vcard-title">{{ $isPt ? 'Cargo' : 'Job Title' }}</label>
                                <input type="text" class="form-control" id="vcard-title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vcard-website">Website</label>
                            <input type="text" class="form-control" id="vcard-website" placeholder="https://">
                        </div>
                        <div class="form-group">
                            <label for="vcard-address">{{ $isPt ? 'Morada' : 'Address' }}</label>
                            <input type="text" class="form-control" id="vcard-address">
                        </div>
                    @endif

                    @if($type === 'email')
                        <div class="form-group">
                            <label for="email-to">{{ $isPt ? 'Enviar Para (Email)' : 'Send To (Email)' }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email-to" placeholder="hello@example.com">
                        </div>
                        <div class="form-group">
                            <label for="email-subject">{{ $isPt ? 'Assunto' : 'Subject' }}</label>
                            <input type="text" class="form-control" id="email-subject">
                        </div>
                        <div class="form-group">
                            <label for="email-body">{{ $isPt ? 'Mensagem' : 'Message Body' }}</label>
                            <textarea class="form-control" id="email-body" rows="3"></textarea>
                        </div>
                    @endif

                    @if($type === 'sms')
                        <div class="form-group">
                            <label for="sms-phone">{{ $isPt ? 'Número de Destino' : 'Destination Number' }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sms-phone" placeholder="+1234567890">
                        </div>
                        <div class="form-group">
                            <label for="sms-message">{{ $isPt ? 'Mensagem' : 'Message' }}</label>
                            <textarea class="form-control" id="sms-message" rows="2"></textarea>
                        </div>
                    @endif

                    @if($type === 'phone')
                        <div class="form-group">
                            <label for="phone-number">{{ $isPt ? 'Número de Telefone' : 'Phone Number' }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone-number" placeholder="+1234567890">
                        </div>
                    @endif

                    @if($type === 'location')
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="loc-lat">Latitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="loc-lat" placeholder="40.7128">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="loc-lng">Longitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="loc-lng" placeholder="-74.0060">
                            </div>
                        </div>
                        <p class="help-block"><small>{{ $isPt ? 'Pode encontrar a latitude/longitude no Google Maps ao clicar com o botão direito num local.' : 'You can find lat/lng on Google Maps by right-clicking a location.' }}</small></p>
                    @endif

                </div>

                <hr>
                <h4><span class="glyphicon glyphicon-tint"></span> {{ $isPt ? 'Aparência' : 'Appearance' }}</h4>
                <div id="qr-appearance-settings">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="qr-color-dark">{{ $isPt ? 'Cor do QR Code' : 'QR Color' }}</label>
                            <input type="color" class="form-control" style="padding:0; height:40px;" id="qr-color-dark" value="#000000">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="qr-color-light">{{ $isPt ? 'Fundo' : 'Background' }}</label>
                            <input type="color" class="form-control" style="padding:0; height:40px;" id="qr-color-light" value="#ffffff">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="qr-size">{{ $isPt ? 'Tamanho (px)' : 'Size (px)' }}</label>
                            <input type="number" class="form-control" id="qr-size" value="250" min="100" max="1000" step="10">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="qr-margin">{{ $isPt ? 'Margem (px)' : 'Margin (px)' }}</label>
                            <input type="number" class="form-control" id="qr-margin" value="15" min="0" max="100" step="5">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qr-logo">{{ $isPt ? 'Logótipo Central (Opcional)' : 'Center Logo (Optional)' }}</label>
                        <input type="file" id="qr-logo" class="form-control" accept="image/png, image/jpeg, image/svg+xml">
                        <p class="help-block"><small>{{ $isPt ? 'O logótipo deve ser quadrado.' : 'Logo should be square.' }}</small></p>
                    </div>
                </div>

                {{-- Privacy Note --}}
                <div class="alert alert-success" style="margin-top: 20px; font-size: 13px;">
                    <span class="glyphicon glyphicon-lock"></span> 
                    <strong>{{ $isPt ? 'Privacidade Garantida:' : 'Privacy Guaranteed:' }}</strong><br>
                    {{ $isPt 
                        ? 'O seu QR Code é gerado localmente no navegador. Os seus dados não são enviados para os nossos servidores.'
                        : 'Your QR code is generated locally in your browser. Your data is not sent to our servers.' 
                    }}
                </div>

            </div>
        </div>
    </div>

    {{-- Right Column: Result --}}
    <div class="col-md-6">
        <div class="panel panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-eye-open"></span> {{ $isPt ? 'Pré-visualização' : 'Preview' }}</h3>
            </div>
            <div class="panel-body text-center">

                <div id="qrcode-container" style="min-height: 280px; display: flex; justify-content: center; align-items: center; background: #fff; border: 1px dashed #ccc; padding: 15px; margin-bottom: 20px;">
                    <span class="text-muted">{{ $isPt ? 'O seu QR Code aparecerá aqui.' : 'Your QR Code will appear here.' }}</span>
                </div>

                <div id="action-buttons" style="display: none;">
                    <button class="btn btn-purple btn-lg btn-block" style="margin-bottom: 15px;" id="btn-download-png">
                        <span class="glyphicon glyphicon-download-alt"></span> {{ $isPt ? 'Descarregar PNG' : 'Download PNG' }}
                    </button>
                    
                    <div class="row">
                        <div class="col-xs-4">
                            <button class="btn btn-default btn-block" id="btn-download-svg" title="Vector format (SVG)">
                                SVG
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-default btn-block" id="btn-copy-img">
                                <span class="glyphicon glyphicon-duplicate"></span> {{ $isPt ? 'Copiar' : 'Copy' }}
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-default btn-block" id="btn-print">
                                <span class="glyphicon glyphicon-print"></span> {{ $isPt ? 'Imprimir' : 'Print' }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
