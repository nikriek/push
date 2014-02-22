<?php
    /*
    * The MIT License (MIT)
  	*
  	* Copyright (c) 2014 Niklas Riekenbrauck
  	*
  	* Permission is hereby granted, free of charge, to any person obtaining a copy
  	* of this software and associated documentation files (the "Software"), to deal
  	* in the Software without restriction, including without limitation the rights
  	* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  	* copies of the Software, and to permit persons to whom the Software is
  	* furnished to do so, subject to the following conditions:
  	*
  	* The above copyright notice and this permission notice shall be included in all
  	* copies or substantial portions of the Software.
  	* 
  	* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  	* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  	* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  	* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  	* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  	* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  	* SOFTWARE.
  	*/
  	
    require_once('push.php');

    //Create a PushCo object with necessary credentials
    $push = new PushCo(array(
        "api_key" => "API_KEY",
        "api_secret" => "API_SECRET"
    ));

    //Different methods to try
    try {
        $push->sendArticleAndImage(
            "Message sent",
            "http://example.de/article",
            "http://example.de/img.jpg");
        $push->sendUrl("Url sent","http://nikriek.de");
        $push->sendLocation("Location sent",13.4113999,52.5234051);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
