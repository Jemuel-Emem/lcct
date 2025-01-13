<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificate</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Container for the certificate */
        .certificate-container {
            width: 70%;
            margin: 20px auto;
            padding: 20px;

            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header section of the certificate */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 5px 0;
        }

        .header h2 {
            font-size: 16px;
            margin: 5px 0;
        }

        /* Logo styling */
        .header img {
            max-width: 80px;
            margin-bottom: 10px;
        }

        /* Content section styling */
        .content {
            margin: 20px 0;
            line-height: 1.6;
        }

        .content p {
            margin: 10px 0;
        }

        .content input {
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            width: calc(100% - 20px);
            margin-left: 10px;
            padding: 2px;
        }


        .remarks {
            margin: 20px 0;
        }


        .footer {
            text-align: right;
            margin-top: 30px;
        }

        .footer p {
            margin: 5px 0;
        }


        @media print {
            body {
                background-color: white;
            }


            .header img {
                max-width: 100px;
            }


            .content input {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            {{-- <img src="{{ url('images/lcct.png') }}" alt="Logo"> --}}
            <h1>La Consolacion College Tanauan</h1>
            <h2>Health Services Unit</h2>
            <h2>MEDICAL CERTIFICATE</h2>
        </div>
        <div class="content">
            <p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
            <p>To whom it may concern:</p>
            <p>This is to certify that <strong>{{ $record->patient->name }}</strong>,</p>
            <p>
                Age <strong>{{ $record->patient->age }}</strong>,
                Sex <strong>{{ $record->patient->sex }}</strong>,
                Civil Status <strong>{{ $record->patient->civil_status }}</strong>,
            </p>
            <p>
                Residing at <input type="text" placeholder="Address">, consulted on
                <strong>{{ $record->created_at->format('F d, Y') }}</strong>,
            </p>
            <p>for <strong>{{ $record->diagnose }}</strong>.</p>
            <p>Impression: <input type="text" placeholder="Impression"></p>
            <p class="remarks"><strong>Remarks:</strong></p>
            <p><input type="text" placeholder="Remarks" style="width: 100%;"></p>
        </div>
        <div class="footer">
            <p>_____________________________</p>
            <p>Physician's Signature over printed name</p>
            <p>License No. __________________</p>
        </div>
    </div>
</body>
</html>
