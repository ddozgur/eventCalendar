<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Etkinlik PDF</title>

        <style>
            @page {
                margin: 10mm;
            }

            body {
                font-family: 'DejaVu Sans', sans-serif;
                font-size: 12px;
            }

            .container {
                width: 100%;
                margin: 0 auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                word-wrap: break-word;
            }

            th {
                background-color: #f2f2f2;
            }

            h2 {
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <center><h2>Etkinlikler</h2></center>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kullanıcı</th>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Başlangıç Saati</th>
                        <th>Bitiş Saati</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        
                        <tr style="border: 2px solid;">
                            <td>{{ $event->user->name }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->start }}</td>
                            <td>{{ $event->end }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </body>
</html>
