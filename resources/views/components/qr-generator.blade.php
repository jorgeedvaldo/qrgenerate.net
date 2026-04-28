{{-- QR Code Generator Component
     Reusable client-side QR code generator.
     All generation happens in the browser — no server requests.
--}}

<div class="row">
    {{-- Left Column: Settings --}}
    <div class="col-md-6">
        <div class="panel panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Configuration</h3>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label for="qr-text">URL or Text Content <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="qr-text" placeholder="https://www.example.com">
                </div>

                <div class="form-group">
                    <label for="qr-logo">Upload Logo (Optional)</label>
                    <input type="file" id="qr-logo" class="form-control" accept="image/png, image/jpeg">
                    <p class="help-block">PNG or JPG. Will be centered on the QR Code.</p>
                </div>

                <div class="color-picker-group">
                    <div>
                        <label for="qr-color-dark">QR Color</label>
                        <input type="color" id="qr-color-dark" value="#000000">
                    </div>
                    <div>
                        <label for="qr-color-light">Background</label>
                        <input type="color" id="qr-color-light" value="#ffffff">
                    </div>
                </div>

                <hr>
                <h4>Print Settings</h4>
                <div class="form-group">
                    <label for="print-text">Call to Action Text (For Printing)</label>
                    <input type="text" class="form-control" id="print-text" value="Scan the code here!"
                        placeholder="e.g., Scan for Menu">
                </div>

                <button class="btn btn-purple btn-lg btn-block" onclick="generateQR()">
                    <span class="glyphicon glyphicon-refresh"></span> Generate QR Code
                </button>

            </div>
        </div>
    </div>

    {{-- Right Column: Result --}}
    <div class="col-md-6">
        <div class="panel panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-eye-open"></span> Preview & Actions
                </h3>
            </div>
            <div class="panel-body text-center">

                <div id="qrcode-container">
                    <span class="text-muted">Your QR Code will appear here.</span>
                </div>

                <div id="action-buttons">
                    <button class="btn btn-default" onclick="downloadQR()">
                        <span class="glyphicon glyphicon-download-alt"></span> Download PNG
                    </button>
                    <button class="btn btn-info" onclick="printQR()">
                        <span class="glyphicon glyphicon-print"></span> Print Flyer
                    </button>
                    <button class="btn btn-warning" onclick="embedQR()">
                        <span class="glyphicon glyphicon-share"></span> Embed HTML
                    </button>

                    <textarea id="embed-code" class="form-control" rows="3" readonly></textarea>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- QR Code Generator JavaScript --}}
@verbatim
<script>
    var currentQRCode = null;

    function generateQR() {
        var text = document.getElementById("qr-text").value.trim();
        var logoFile = document.getElementById("qr-logo").files[0];
        var colorDark = document.getElementById("qr-color-dark").value;
        var colorLight = document.getElementById("qr-color-light").value;
        var container = document.getElementById("qrcode-container");

        if (!text) {
            alert("Please enter a URL or text to generate the QR Code.");
            return;
        }

        // Clear previous QR
        container.innerHTML = "";

        // Base options
        var options = {
            text: text,
            width: 250,
            height: 250,
            colorDark: colorDark,
            colorLight: colorLight,
            correctLevel: QRCode.CorrectLevel.H, // Required for logos
            quietZone: 15,
            quietZoneColor: colorLight
        };

        // If user uploaded a logo
        if (logoFile) {
            var reader = new FileReader();
            reader.onload = function (e) {
                options.logo = e.target.result;
                options.logoWidth = 60;
                options.logoHeight = 60;
                options.logoBackgroundTransparent = false;
                options.logoBackgroundColor = colorLight;

                renderQR(container, options);
            };
            reader.readAsDataURL(logoFile);
        } else {
            renderQR(container, options);
        }
    }

    function renderQR(container, options) {
        currentQRCode = new QRCode(container, options);
        document.getElementById("action-buttons").style.display = "block";
        document.getElementById("embed-code").style.display = "none";
    }

    function getBase64Image() {
        var canvas = document.querySelector("#qrcode-container canvas");
        return canvas ? canvas.toDataURL("image/png") : null;
    }

    function downloadQR() {
        var base64 = getBase64Image();
        if (!base64) return;

        var link = document.createElement('a');
        link.download = 'QrGenerate-Code.png';
        link.href = base64;
        link.click();
    }

    function embedQR() {
        var base64 = getBase64Image();
        if (!base64) return;

        var textarea = document.getElementById("embed-code");
        var htmlString = `<img src="${base64}" alt="Generated QR Code" width="250" height="250">`;

        textarea.value = htmlString;
        textarea.style.display = "block";
        textarea.select();
    }

    function printQR() {
        var base64 = getBase64Image();
        var printText = document.getElementById("print-text").value || "Scan the code here!";

        if (!base64) return;

        var printWindow = window.open('', '_blank', 'width=800,height=800');

        var printHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    body {
                        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        margin: 0;
                        text-align: center;
                    }
                    .print-container {
                        border: 3px dashed #333;
                        padding: 50px;
                        border-radius: 15px;
                    }
                    h1 {
                        font-size: 48px;
                        color: #333;
                        margin-bottom: 30px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                    }
                    img {
                        width: 400px;
                        height: 400px;
                        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                    }
                    @media print {
                        .print-container { border: none; }
                        img { box-shadow: none; }
                    }
                </style>
            </head>
            <body>
                <div class="print-container">
                    <h1>${printText}</h1>
                    <img src="${base64}" onload="window.print(); window.close();" />
                </div>
            </body>
            </html>
        `;

        printWindow.document.write(printHTML);
        printWindow.document.close();
    }
</script>
@endverbatim
