<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Code</title>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>Feature</th>
            <th>Button PHPUnit</th>
            <th>Button Dusk</th>
        </tr>
        <tr>
            <td>Login</td>
<<<<<<< HEAD
            <td><button>BTN 1</button></td>
            <td><button>BTN 2</button></td>
        </tr>
    </table>
=======
            <form action="/generate" method="post">
            {{ csrf_field() }}
                <td><input type="submit" value="Submit" name="btnIPA" class="btn bg-success"></td>
                <td></td>
                <!-- <td><button>BTN 1</button></td>
                <td><button>BTN 2</button></td> -->
            </form>
            
        </tr>
    </table>

    <?php
        print($dir);
// use App\User;

// $model = new User();
//         $fill = $model->getFillable();
//         print_r($fill);
    ?>
>>>>>>> 5e25bcafc78be4f00b50db6ab148406814913adf
</body>

</html>