/**
 * QR Code Generator Logic
 * Powered by easyqrcodejs
 */

document.addEventListener('DOMContentLoaded', function () {
    // Current QR code instance
    window.currentQRCode = null;

    // Elements
    const form = document.getElementById('qr-dynamic-form');
    if (!form) return;

    const container = document.getElementById('qrcode-container');
    const colorDark = document.getElementById('qr-color-dark');
    const colorLight = document.getElementById('qr-color-light');
    const qrSize = document.getElementById('qr-size');
    const qrMargin = document.getElementById('qr-margin');
    const logoFile = document.getElementById('qr-logo');
    const qrType = document.getElementById('qr-type-val').value;

    // Actions
    const downloadPngBtn = document.getElementById('btn-download-png');
    const downloadSvgBtn = document.getElementById('btn-download-svg');
    const copyImgBtn = document.getElementById('btn-copy-img');
    const printBtn = document.getElementById('btn-print');

    // Debounce timer for real-time preview
    let debounceTimer;

    // Attach event listeners to all inputs to trigger generation
    const inputs = document.querySelectorAll('#qr-dynamic-form input, #qr-dynamic-form select, #qr-dynamic-form textarea, #qr-appearance-settings input');
    inputs.forEach(input => {
        input.addEventListener('input', scheduleGenerate);
        input.addEventListener('change', scheduleGenerate);
    });

    if (logoFile) {
        logoFile.addEventListener('change', scheduleGenerate);
    }

    // Action button listeners
    if (downloadPngBtn) downloadPngBtn.addEventListener('click', downloadPNG);
    if (downloadSvgBtn) downloadSvgBtn.addEventListener('click', downloadSVG);
    if (printBtn) printBtn.addEventListener('click', printQR);
    if (copyImgBtn) copyImgBtn.addEventListener('click', copyImage);

    // Initial generate
    generateQR();

    function scheduleGenerate() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(generateQR, 300);
    }

    function buildQRString() {
        let str = '';
        
        switch (qrType) {
            case 'wifi':
                const ssid = document.getElementById('wifi-ssid').value;
                const password = document.getElementById('wifi-password').value;
                const enc = document.getElementById('wifi-encryption').value;
                const hidden = document.getElementById('wifi-hidden').checked;
                str = `WIFI:T:${enc};S:${ssid};P:${password};H:${hidden};;`;
                if (!ssid) str = ''; // Don't generate if empty
                break;

            case 'whatsapp':
                let waPhone = document.getElementById('wa-phone').value.replace(/[^0-9]/g, '');
                let waCode = document.getElementById('wa-code').value.replace(/[^0-9]/g, '');
                const waMsg = encodeURIComponent(document.getElementById('wa-message').value);
                if (waPhone) {
                    str = `https://wa.me/${waCode}${waPhone}?text=${waMsg}`;
                }
                break;

            case 'vcard':
                const fn = document.getElementById('vcard-fname').value;
                const ln = document.getElementById('vcard-lname').value;
                const phone = document.getElementById('vcard-phone').value;
                const email = document.getElementById('vcard-email').value;
                const company = document.getElementById('vcard-company').value;
                const title = document.getElementById('vcard-title').value;
                const website = document.getElementById('vcard-website').value;
                const address = document.getElementById('vcard-address').value;
                
                if (fn || ln || phone || email) {
                    str = `BEGIN:VCARD\nVERSION:3.0\nN:${ln};${fn};;;\nFN:${fn} ${ln}\n`;
                    if (company) str += `ORG:${company}\n`;
                    if (title) str += `TITLE:${title}\n`;
                    if (phone) str += `TEL;TYPE=CELL:${phone}\n`;
                    if (email) str += `EMAIL;TYPE=WORK,INTERNET:${email}\n`;
                    if (website) str += `URL:${website}\n`;
                    if (address) str += `ADR;TYPE=WORK:;;${address};;;;\n`;
                    str += `END:VCARD`;
                }
                break;

            case 'email':
                const to = document.getElementById('email-to').value;
                const sub = encodeURIComponent(document.getElementById('email-subject').value);
                const body = encodeURIComponent(document.getElementById('email-body').value);
                if (to) {
                    str = `mailto:${to}?subject=${sub}&body=${body}`;
                }
                break;

            case 'sms':
                const smsPhone = document.getElementById('sms-phone').value;
                const smsMsg = encodeURIComponent(document.getElementById('sms-message').value);
                if (smsPhone) {
                    str = `sms:${smsPhone}?body=${smsMsg}`;
                }
                break;

            case 'phone':
                const tel = document.getElementById('phone-number').value;
                if (tel) {
                    str = `tel:${tel}`;
                }
                break;

            case 'location':
                const lat = document.getElementById('loc-lat').value;
                const lng = document.getElementById('loc-lng').value;
                if (lat && lng) {
                    str = `geo:${lat},${lng}`;
                }
                break;

            // Default handles url, text, instagram, pdf, restaurant-menu, etc.
            default:
                const textInput = document.getElementById('qr-text');
                if (textInput) {
                    str = textInput.value.trim();
                }
                break;
        }

        return str;
    }

    function generateQR() {
        const text = buildQRString();
        
        if (!text) {
            container.innerHTML = '<span class="text-muted">Fill out the fields to generate your QR Code.</span>';
            document.getElementById("action-buttons").style.display = "none";
            return;
        }

        container.innerHTML = ""; // Clear existing

        const size = parseInt(qrSize.value) || 250;
        const qzone = parseInt(qrMargin.value) || 15;

        const options = {
            text: text,
            width: size,
            height: size,
            colorDark: colorDark.value,
            colorLight: colorLight.value,
            correctLevel: QRCode.CorrectLevel.H, // Always H to support logos
            quietZone: qzone,
            quietZoneColor: colorLight.value,
            drawer: 'canvas' // Default to canvas for PNG
        };

        if (logoFile && logoFile.files && logoFile.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                options.logo = e.target.result;
                // Calculate logo size relative to QR size (max ~25% coverage)
                options.logoWidth = size * 0.25;
                options.logoHeight = size * 0.25;
                options.logoBackgroundTransparent = false;
                options.logoBackgroundColor = colorLight.value;

                renderQR(options);
            };
            reader.readAsDataURL(logoFile.files[0]);
        } else {
            renderQR(options);
        }
    }

    function renderQR(options) {
        // Render Canvas (for UI and PNG)
        window.currentQRCode = new QRCode(container, options);
        
        // Also render SVG invisibly for download SVG
        const svgContainer = document.createElement('div');
        svgContainer.id = 'qrcode-svg-container';
        svgContainer.style.display = 'none';
        container.appendChild(svgContainer);
        
        const svgOptions = Object.assign({}, options, { drawer: 'svg' });
        new QRCode(svgContainer, svgOptions);

        document.getElementById("action-buttons").style.display = "block";
    }

    // Export Functions
    function getCanvas() {
        return container.querySelector("canvas");
    }

    function getSVG() {
        return container.querySelector("svg");
    }

    function downloadPNG() {
        const canvas = getCanvas();
        if (!canvas) return;

        const link = document.createElement('a');
        link.download = 'QrGenerate.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
    }

    function downloadSVG() {
        const svg = getSVG();
        if (!svg) return;

        const svgData = new XMLSerializer().serializeToString(svg);
        const blob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
        const url = URL.createObjectURL(blob);
        
        const link = document.createElement('a');
        link.download = 'QrGenerate.svg';
        link.href = url;
        link.click();
        
        // Clean up
        setTimeout(() => URL.revokeObjectURL(url), 100);
    }

    function copyImage() {
        const canvas = getCanvas();
        if (!canvas) return;

        canvas.toBlob(function(blob) {
            try {
                const item = new ClipboardItem({ "image/png": blob });
                navigator.clipboard.write([item]).then(() => {
                    const btn = document.getElementById('btn-copy-img');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="glyphicon glyphicon-ok"></span> Copied!';
                    setTimeout(() => btn.innerHTML = originalText, 2000);
                });
            } catch (err) {
                alert("Your browser does not support copying images to clipboard.");
            }
        });
    }

    function printQR() {
        const canvas = getCanvas();
        if (!canvas) return;

        const base64 = canvas.toDataURL("image/png");
        const printWindow = window.open('', '_blank', 'width=800,height=800');

        const printHTML = `
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
                    img {
                        width: 400px;
                        height: 400px;
                    }
                </style>
            </head>
            <body>
                <img src="${base64}" onload="window.print(); window.close();" />
            </body>
            </html>
        `;

        printWindow.document.write(printHTML);
        printWindow.document.close();
    }
});
