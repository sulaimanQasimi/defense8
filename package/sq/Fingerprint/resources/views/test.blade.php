<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secugen-Demo1 - SecuGen Corporation</title>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    // nice global area, so that only 1 location, contains this information
    var secugen_lic = "";

    function setFormAction() {
        // This function is called on page load
        // No action needed for the demo
    }

    function captureFP() {
        CallSGIFPGetData(SuccessFunc, ErrorFunc);
    }

    /*
        This functions is called if the service sucessfully returns some data in JSON object
    */
    function SuccessFunc(result) {
        if (result.ErrorCode == 0) {
            /* 	Display BMP data in image tag
                BMP data is in base 64 format
            */
            if (result != null && result.BMPBase64.length > 0) {
                document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.BMPBase64;
            }
            var tbl = "<table border=1>";
            tbl += "<tr>";
            tbl += "<td> Serial Number of device </td>";
            tbl += "<td> <b>" + result.SerialNumber + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Image Height</td>";
            tbl += "<td> <b>" + result.ImageHeight + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Image Width</td>";
            tbl += "<td> <b>" + result.ImageWidth + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Image Resolution</td>";
            tbl += "<td> <b>" + result.ImageDPI + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Image Quality (1-100)</td>";
            tbl += "<td> <b>" + result.ImageQuality + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> NFIQ (1-5)</td>";
            tbl += "<td> <b>" + result.NFIQ + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Template(base64)</td>";
            tbl += "<td> <b> <textarea rows=8 cols=50>" + result.TemplateBase64 + "</textarea></b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> Image WSQ Size</td>";
            tbl += "<td> <b>" + result.WSQImageSize + "</b> </td>";
            tbl += "</tr>";
            tbl += "<tr>";
            tbl += "<td> EncodeWSQ(base64)</td>";
            tbl += "<td> <b> <textarea rows=8 cols=50>" + result.WSQImage + "</textarea></b> </td>";
            tbl += "</tr>";
            tbl += "</table>";
            document.getElementById('result').innerHTML = tbl;
        }
        else {
            alert("Fingerprint Capture Error Code:  " + result.ErrorCode + ".\nDescription:  " + ErrorCodeToString(result.ErrorCode) + ".");
        }
    }

    function ErrorFunc(status) {
        /*
            If you reach here, user is probabaly not running the
            service. Redirect the user to a page where he can download the
            executable and install it.
        */
        alert("Check if SGIBIOSRV is running; Status = " + status + ":");
    }

    function CallSGIFPGetData(successCall, failCall) {
        // 8.16.2017 - At this time, only SSL client will be supported.
        var uri = "https://localhost:8443/SGIFPCapture";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                fpobject = JSON.parse(xmlhttp.responseText);
                successCall(fpobject);
            }
            else if (xmlhttp.status == 404) {
                failCall(xmlhttp.status)
            }
        }
        var params = "Timeout=" + "10000";
        params += "&Quality=" + "50";
        params += "&licstr=" + encodeURIComponent(secugen_lic);
        params += "&templateFormat=" + "ISO";
        params += "&imageWSQRate=" + "0.75";

        xmlhttp.open("POST", uri, true);
        xmlhttp.send(params);

        xmlhttp.onerror = function () {
            failCall(xmlhttp.statusText);
        }
    }

    function ErrorCodeToString(ErrorCode) {
        var Description;
        switch (ErrorCode) {
            // 0 - 999 - Comes from SgFplib.h
            // 1,000 - 9,999 - SGIBioSrv errors
            // 10,000 - 99,999 license errors
            case 51:
                Description = "System file load failure";
                break;
            case 52:
                Description = "Sensor chip initialization failed";
                break;
            case 53:
                Description = "Device not found";
                break;
            case 54:
                Description = "Fingerprint image capture timeout";
                break;
            case 55:
                Description = "No device available";
                break;
            case 56:
                Description = "Driver load failed";
                break;
            case 57:
                Description = "Wrong Image";
                break;
            case 58:
                Description = "Lack of bandwidth";
                break;
            case 59:
                Description = "Device Busy";
                break;
            case 60:
                Description = "Cannot get serial number of the device";
                break;
            case 61:
                Description = "Unsupported device";
                break;
            case 63:
                Description = "SgiBioSrv didn't start; Try image capture again";
                break;
            default:
                Description = "Unknown error code or Update code to reflect latest result";
                break;
        }
        return Description;
    }
    </script>
</head>
<body onload="setFormAction();">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="./" class="navbar-brand">SecuGen WebAPI</a>
                </div>
                <div class="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="./docs/SECUGEN_WEB_SERVICE_API_DOC.pdf">WebAPI Doc</a></li>
                        <li><a href="./download/SGI_BWAPI_WIN_64bit.exe">Win64b WebAPI</a></li>
                        <li><a href="./download/SGI_BWAPI_WIN_32bit.exe">Win32b WebAPI</a></li>
                        <li><a href="Demo1.aspx">Demo 1</a></li>
                        <li><a href="Demo2.aspx">Demo 2</a></li>
                        <li><a href="Demo3.aspx">Demo 3</a></li>
                        <li><a href="https://webapipython.secugen.com">WebAPI Python</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container body-content">
            <div class="row">
                <div class="row" style="text-indent: 50px;">
                    <h1><b>WebAPI</b></h1>
                </div>
                <h3><b>Demonstration of Single Fingerprint Scanning</b></h3>
                <div class="col-md-10">
                    <p>
                        <b>This demo runs a single fingerprint scan. You can easily retrieve the image data, template, serial number, NFIQ value and other relevant information in a single call.</b>
                    </p>
                    <div class="row">
                        <table width="1012" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr align="center">
                                <td class="auto-style2" align="right" valign="top">
                                    &nbsp;
                                </td>
                                <td class="style3">
                                <span class="download_href">
                                    <img id="FPImage1" alt="Fingerpint Image" height=300 width=210 align="center" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII="> <br>
                                    <input type="button" value="Click to Scan" onclick="captureFP()"><br>
                                    <br>
                                    <p id="result"/>.
                                </span>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="style2">&nbsp;</td>
                                <td class="style3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <hr />
            <footer>
                <p>&copy; 2025 - SecuGen Corporation</p>
            </footer>
        </div>
</body>
</html>
