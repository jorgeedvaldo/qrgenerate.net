---
title: "How to Create a QR Code for Wi-Fi"
slug: "how-to-create-a-qr-code-for-wifi"
locale: "en"
description: "Create a QR code that connects smartphones to your Wi-Fi network automatically. Learn the Wi-Fi QR format and best practices for hotels, cafés, and offices."
date: "2024-09-10"
updated_at: "2024-10-01"
category: "Tutorials"
tags: ["wifi", "qr code", "networking", "hospitality"]
alternate_slug: "como-criar-qr-code-para-wifi"
---

## Why Use a Wi-Fi QR Code?

Sharing a Wi-Fi password verbally or on a printed card is inconvenient and error-prone. A Wi-Fi QR code lets guests connect to your network with a single scan — no typing required. Both iOS (11+) and Android support this feature natively through the camera app.

## The Wi-Fi QR Code Format

The standard format is:

```
WIFI:T:WPA;S:NetworkName;P:YourPassword;;
```

### Parameters

| Parameter | Description | Values |
|-----------|------------|--------|
| `T` | Security type | `WPA`, `WEP`, or empty for open |
| `S` | Network name (SSID) | Your Wi-Fi name |
| `P` | Password | Your Wi-Fi password |
| `H` | Hidden network | `true` if hidden, omit otherwise |

**Example for a hidden WPA network:**

```
WIFI:T:WPA;S:MyHiddenNetwork;P:SuperSecret123;H:true;;
```

## Step-by-Step

1. Find your Wi-Fi network name (SSID) and password.
2. Build the string using the format above.
3. Paste it into [QrGenerate.net](https://qrgenerate.net).
4. Generate the QR code and download.
5. Print and display near your router or entrance.

## Where to Display Wi-Fi QR Codes

- **Hotels and B&Bs:** In-room welcome cards or bedside tables.
- **Restaurants and cafés:** Table tents, menus, or wall posters.
- **Offices:** Meeting rooms, reception areas, or co-working spaces.
- **Airbnb and rentals:** Welcome guides or fridge magnets.

## Security Tip

Change your Wi-Fi password periodically and regenerate the QR code. For guest networks, consider creating a separate SSID with limited bandwidth so your primary network remains secure.
