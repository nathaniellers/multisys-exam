<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <title>Success Registration: </title>
    <style type="text/css">
      @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap");
      p,
      h1,
      h2,
      h3,
      h4,
      ol,
      li,
      ul {
        font-family: "Montserrat", "Inter", Helvetica;
      }
    </style>
  </head>
  <body>
  <table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
    <tr>
      <td
        style="
          padding-top: 45px;
          padding-bottom: 45px;
          margin-bottom: 30px;
          width: 100%;
          margin-left: auto;
          margin-right: auto;
        "
      >
        <p
          style="
            font-weight: 700;
            font-size: 15px;
            font-style: normal;
            line-height: 18.29px;
            text-align: center;
            color: #000;
            margin: 0;
            font-family: 'Montserrat', Helvetica;
          "
        >
          Success Registration
        </p>
      </td>
    </tr>
    <tr>
      <td
      >
        <tr style="
          height: 200px;
          background-color: #f7f7f7;
          "
        >
          <td style="width: 100%; padding-left: 10%; padding-right: 10%">
            <h1
            style="
                font-weight: 400;
                font-size: 16px;
                font-style: normal;
                line-height: 0px;
                color: #4a4a59;
                margin: 0;
                margin-bottom: 25px;
                font-family: 'Inter', Helvetica;
                "
            >
              Hi this is your credentials.
            </h1>
            <p
              style="
                font-weight: 400;
                font-size: 16px;
                font-style: normal;
                line-height: -50px;
                color: #4a4a59;
                margin: 0;
                font-family: 'Inter', Helvetica;
              "
            >
              Email: <span style="font-weight: 700">{{$data['email']}}</span>
            </p>
            <p
              style="
                font-weight: 400;
                font-size: 16px;
                font-style: normal;
                line-height: -50px;
                color: #4a4a59;
                margin: 0;
                font-family: 'Inter', Helvetica;
              "
            >
            Password: <span style="font-weight: 700">{{$data['password']}}</span>
          </p>
          </td>
        <tr>
        </tr>
      </td>
    </tr>  
  </table>
  </body>
</html>
