var serveraddress_input = null; // serveraddress input field
var username_input = null;      // sip account username input field
var password_input = null;      // sip account password input field
//var destination_input = null;   // destination number or SIP URI input field

function InitializeTextInputs()
{
    if (isNull(serveraddress_input))
    {
        serveraddress_input = document.getElementById('serveraddress');
        username_input = document.getElementById('username');
        password_input = document.getElementById('password');
        //destination_input = document.getElementById('destinationnr');
    }
}

/*function Start() // function called on "Register" button click to start the webphone
{
    InitializeTextInputs();
    var serveraddress = serveraddress_input.value;
    var username = username_input.value;
    var password = password_input.value;
    //var destination = destination_input.value;
    
    if((username != "") && (password != "")) {
        if (!isNull(serveraddress) && serveraddress.length > 0)
        {
            webphone_api.setparameter('serveraddress', serveraddress);
        }
        webphone_api.setparameter('username', username);
        webphone_api.setparameter('password', password);
        //webphone_api.setparameter('destination', destination);
        
        SaveSettings();
        
        DisplayStatus('EVENT, Initializing...');

        webphone_api.start();

    // populate advanced settings form
        PopulateSettings();
    }
}*/

// Wait until the webphone is loaded, before calling any API functions
// if automatic start is required, then webphone_api.start() should be called "onLoaded" event like this:
//      webphone_api.onAppStateChange(function (state)
//      {
//            if (state === 'laoded')
//            {
//              webphone_api.start();
//            }
//      });
webphone_api.onAppStateChange(function (state)
{
    if (state === 'loaded')
    {
        /*InitializeTextInputs();
        var serveraddress = serveraddress_input.value;
        var username = username_input.value;
        var password = password_input.value;*/
        //var destination = destination_input.value;
        
        if((userMizutechName != "") && (userMizutechPwd != "")) {
            
                webphone_api.setparameter('serveraddress', VOIP_SERVER_ADDRESS);
            
            webphone_api.setparameter('username', userMizutechName);
            webphone_api.setparameter('password', userMizutechPwd);
            //webphone_api.setparameter('destination', destination);
            
            //SaveSettings();
            
            DisplayStatus('EVENT, Initializing...' + webphone_api.getparameter('username'));

            webphone_api.start();//pooja :comment

        // populate advanced settings form
            //PopulateSettings();
        }
        else {
            if(webphone_api.getparameter("username") != "") {
                webphone_api.unregister();
                webphone_api.stop();
            }
        }
    }
});

webphone_api.onRegStateChange(function (regState)
{
    if (regState === 'registered')
    {
        //alert("registered");
    }
    else if (regState === 'unregistered')
    {
        //alert("unregistered");
    }
    else if (regState === 'failed')
    {
        //toastr["error"](lang.INVALID_MIZUTECH_DETAILS);
    }
});
/** Displays sent/received messages in chat form window*/
function AddMessageToHistory(to, message)
{
    var sentmsgF = document.getElementById('msg_list');
    var msgconttent = sentmsgF.innerHTML;
    
    if (isNull(msgconttent)) { msgconttent = ''; }
    
    var item = '';
    
    if (!isNull(to) && to.length > 0)
    {
        item = '<b>' + to + ':</b><p>' + message + '</p><p class="date">' + GetDateForMessage() + '</p>';
    }else
    {
        item = '<p>' + message + '</p>';
    }
    
    msgconttent = msgconttent + item + '<br />';
    
    sentmsgF.innerHTML = msgconttent;
// scroll to bottom
    var d = $('#msg_list');
    d.scrollTop(d.prop("scrollHeight"));
}

/** helper function; returns the current date and time in string displayable format*/
function GetDateForMessage()
{
    var month = new Array();
    month[0] = 'Jan'; month[1] = 'Feb'; month[2] = 'Mar'; month[3] = 'Apr'; month[4] = 'May'; month[5] = 'Jun';
    month[6] = 'Jul'; month[7] = 'Aug'; month[8] = 'Sep'; month[9] = 'Oct'; month[10] = 'Nov'; month[11] = 'Dec';
    try{
    var date = new Date();

    var minutes = date.getMinutes();
    if (minutes < 10) { minutes = '0' + minutes; }

    var day = date.getDate(); // getDay returns the day of the week
    if (day < 10) { day = '0' + day; }

    var datestr = month[date.getMonth()] + ', ' + day + ' ' + date.getFullYear()+ ' '
            + date.getHours() + ':' + minutes;
    
    return datestr;

    } catch(err) { PutToDebugLogException(2, "_message: GetDateForMessage", err); }
    return '';
}

/** receive important events from webphone, which will be displayed for the user and parsed to perform other actions*/
webphone_api.onEvent(function (type, evt)
{
    if (type === 'event')
    {
        ProcessNotifications(evt);
    }
});

/** parse received notifications*/
var ringingNumber = '';
function ProcessNotifications(not)
{
    try{
    if (isNull(not) || not.length < 1) { return; }
    
    not = Trim(not);
    
    var type = '';
    var line = '';
    var notifyword = '';
    
    //STATUS,1,Ringing,8888,9999,2,8888
    var pos = not.indexOf(',');
    if (pos > 0)
    {
        type = Trim(not.substring(0, pos));
        not = Trim(not.substring(pos + 1));
    }
    
// get line
    pos = not.indexOf(',');
    if (pos > 0)
    {
        line = Trim(not.substring(0, pos));
        notifyword = Trim(not.substring(pos + 1));
    }else
    {
        notifyword = not;
    }

    var notifywordcontent = '';
    
// clear junk of notifyword's end
    pos = notifyword.indexOf(',');
    if (pos > 0)
    {
        notifywordcontent = Trim(notifyword.substring(pos + 1));
        notifyword = Trim(notifyword.substring(0, pos));
    }
    pos = notifyword.indexOf('[');
    if (pos > 0) { notifyword = Trim(notifyword.substring(0, pos)); }
    pos = notifywordcontent.indexOf('[');
    if (pos > 0) { notifywordcontent = Trim(notifywordcontent.substring(0, pos)); }
    
    
// handle incoming call
    if (type === 'STATUS')
    {
        // you can futher process/use the received status event messages
        // check the documentation for more details
    }
    
    DisplayStatus(type + ',' + notifyword);
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: ProcessNotifications', err); }
}

/** Custom popup with Accept/Reject buttons displayed on incoming call
 * This is just an example, you can design/use your own custom popup*/
var armodal = null;
function AcceptRejectPopup(from)
{
    try{
    if (!isNull(armodal))
    {
        armodal.show();
        return;
    }
    armodal = webphone_api.picoModal(
    {
        content: 
            '<div id="ce_modal" class="modal" style="color: #212121;">'+
                '<div id="ce_modal_header" class="modal_header_custom" style="height: 2.2em; line-height: 2.2em; margin: 0; background: #e8e8e8; text-align: center; color: #212121; font-weight: bold;">' +
                    'Incoming call' +
                '</div>' +
                '<div id="ce_modal_content" class="modal_content" style="font-size: .8em; padding: 1em;">' +
                    '<div id="ce_modal_content_inner">' +
                        'Incoming call from: ' + from +
                    '</div>' +
                '</div>' +
                '<div id="ce_modal_footer" class="modal_footer" style="height: 2.2em; margin: 0; background: #e8e8e8; text-align: center; color: #ffffff; font-weight: bold;">' +
                    '<button id="btn_np_positive" style="width: 50%; height: 2.28em; margin-top: .1em; font-size: .9em; color: #212121; font-weight: bold; background: #cecece; border: .1em solid #b8b8b8; border-radius: .2em; cursor: pointer;">Accept</button>' +
                    '<button id="btn_np_negative" style="width: 50%; height: 2.28em; margin-top: .1em; font-size: .9em; color: color: #212121; font-weight: bold; background: #cecece; border: .1em solid #b8b8b8; border-radius: .2em; cursor: pointer;">Reject</button>' +
                '</div>' +
            '</div>',
        //content: "Ah, the pitter patter of tiny feet in huge combat boots.<br><button>Test</button>",
        overlayStyles: { backgroundColor: "#565656", opacity: 0.6 },
        modalStyles:
        {
            padding: "0",
            margin: "0",
            //top: "0",
            border: ".2em solid #d8d8d8",
            borderRadius: ".4em",
            //width: '65%',
            width: 'auto',
            //height: '100%',
            background: "#ffffff", fontFamily: "sans-serif",
        },
        //closeHtml: "<span>Close</span>",
        closeButton: false,
        overlayClose: false,
        closeStyles:
        {
            background: "#eeeeee", position: "absolute", top: ".2em", right: ".3em", textAlign: "center",
            fontSize: "1.2em", fontWeight: "bold", border: ".15em solid #bbb", borderRadius: ".8em",
            paddingLeft: ".25em", paddingRight: ".25em", cursor: "pointer",
        },

        //comment: custom classes
        //overlayClass: "customShadow",
        //modalClass: "customModal",
        //closeClass: "customClose"

        // events
    }).afterCreate(function (modal)
    {
        ;
    })
    .beforeShow(function (modal, event)
    {
        ;
    })
    .afterShow(function (modal)
    {
        ;
    })
    .beforeClose(function (modal, event)
    {
        ;
    })
    .afterClose(function(modal)
    {
        modal.destroy(); // must be called, otherwise on next show() the onclick will not work
        armodal = null;
    });
    
    armodal.show();
    
    $("#btn_np_positive").on("click", function ()
    {
        armodal.close();
        PutToDebugLog(5,"EVENT, live_demo AcceptRejectPopup Accept onclick");
        Accept();
    });

    $("#btn_np_negative").on("click", function ()
    {
        armodal.close();
        PutToDebugLog(5,"EVENT, live_demo AcceptRejectPopup Reject onclick");
        Reject();
    });
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: AcceptRejectPopup', err); }
}

/** display events/status messages for the user*/
var status_e = null;
function DisplayStatus(msg_orig)
{
    try{
    var msg = msg_orig;
    if (isNull(status_e)) { status_e = document.getElementById('status'); }
    
    if (isNull(msg) || msg.length < 1) { msg = '&nbsp;'; }
    if (msg.toLowerCase().indexOf('subscribe') >= 0) { return; }
    
    if (msg.indexOf('ERROR') >= 0)
    {
        msg = msg.replace('ERROR', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
        
        msg = '<span style="color:red;">' + msg + '</span>';
    }
    else if (msg.indexOf('WARNING') >= 0)
    {
        msg = msg.replace('WARNING', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
        
        msg = '<span style="color: #ff6600;">' + msg + '</span>';
    }
    else if (msg.indexOf('STATUS') >= 0 || msg.indexOf('EVENT') >= 0)
    {
        msg = msg.replace('STATUS', '');
        msg = msg.replace('EVENT', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
    }
    
    status_e.innerHTML = msg;
    PutToDebugLog(2, 'NOT: ' + msg_orig);
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: DisplayStatus', err); }
}


// ------------------ helper functions



/** this function is used to build the form for the Other settings
 * if you wish to display/present these setting to the user, you should build your own simple html*/
function PopulateSettings()
{
    try{
    if ( isNull(webphone_api.global.settmap2) || isNull( webphone_api.global.settmap2['magicnumber'] ))
    {
        PutToDebugLog(2, 'live_demo: PopulateSettings, webphone_api.global.settmap is NULL');
        return;
    }
// callerid, displayname, proxyaddress, webrtcserveraddress
    var callerid_description = 'This will not be used for authentication. Specify if not the same with the Username for authentication setting. Some VoIP servers will reject if not the same with the username!';
    var displayname_description = 'Specify display name. This is an optional setting and it should be your full name';
    var proxyaddress_description = 'Outbound SIP proxy address. Leave it empty if you don’t have a stateless/outbound proxy';
    var webrtcserveraddress_description = 'Optional setting to indicate the domain name or IP address of your websocket service used for WebRTC if any.';
    var content = '' +
        '<div class="sett_form">' +
            '<label for="username" title="' + callerid_description + '">Caller ID:</label>' +
            '<input type="text" placeholder="Caller ID" id="username" value="' + webphone_api.getparameter('username') + '" title="' + callerid_description + '" autocapitalize="off" />' +
        '</div>' +

        '<div class="sett_form">' +
            '<label for="displayname" title="' + displayname_description + '">Display name:</label>' +
            '<input type="text" placeholder="Display name" id="displayname" value="' + webphone_api.getparameter('displayname') + '" title="' + displayname_description + '" autocapitalize="off" />' +
        '</div>' +

        '<div class="sett_form">' +
            '<label for="proxyaddress" title="' + proxyaddress_description + '">Proxy address:</label>' +
            '<input type="text" placeholder="Proxy address" id="proxyaddress" value="' + webphone_api.getparameter('proxyaddress') + '" title="' + proxyaddress_description + '" autocapitalize="off" />' +
        '</div>' +

        '<div class="sett_form">' +
            '<label for="webrtcserveraddress" title="' + webrtcserveraddress_description + '">WebRTC Server:</label>' +
            '<input type="text" placeholder="WebRTC Server" id="webrtcserveraddress" value="' + webphone_api.getparameter('webrtcserveraddress') + '" title="' + webrtcserveraddress_description + '" autocapitalize="off" />' +
            //'<span>*WebRTC Server Address is optional. If not set, then the built in WebRTC gateway will be used.</span>' +
        '</div>';

    var settings_list = document.getElementById('settings_list');
    if (!isNull(settings_list))
    {
        settings_list.innerHTML = content;
    }else
    {
        PutToDebugLog(5,"EVENT, live_demo PopulateSettings list element is NULL");
    }
    } catch(err) { PutToDebugLogException(2, 'live_demo: PopulateSettings', err); }
}

/** called on "Save settings" button clicked
 * Save settings from Advanced Settings form*/
function SaveSettings()
{
    try{
    function SaveSett(id)
    {
        var input = document.getElementById(id);
        if (!isNull(input))
        {
            var val = input.value;
            if (isNull(val)) { val = ''; }
            val = Trim(val);
            
            webphone_api.setparameter(id, val);
        }
    }
    
    SaveSett('username');
    SaveSett('displayname');
    SaveSett('proxyaddress');
    SaveSett('webrtcserveraddress');
    
    DisplayStatus('EVENT,Saved');
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: SaveSettings', err); }
}

/** Display/hide Advanced Settings form*/
function ShowHideAdvancedSettings()
{
    var rcolumn = document.getElementById('right_column');
    var btnadv = document.getElementById('btn_advanced_sett');
    if (isNull(rcolumn) || isNull(btnadv)) { return; }
    
    btnadv.style.display = 'none';
    
    if (rcolumn.style.display === 'none')
    {
        document.getElementById('left_column').style.marginLeft = '0';
        document.getElementById('right_column').style.display = 'block';
        btnadv.innerHTML = 'Hide Advanced Settings';
    }else
    {
        document.getElementById('right_column').style.display = 'none';
        btnadv.innerHTML = 'Show Advanced Settings';
    }
}

/** Helper function which returns "true" if the passed valiable is not NULL and it's not UNDEFINED*/
function isNull (variable)
{
    try{
    if (typeof (variable) === 'undefined' || variable === null)
    {
        return true;
    }else
    {
        return false;
    }
    } catch(err) { PutToDebugLogException(2, "common: isNull", err); }
    
    return true;
}

function Trim(str)
{
    try{
    if (isNull(str) || str.lenght < 1) { return ''; }
    
    str = str.toString();
    return str.replace(/^\s+|\s+$/g, ''); 
    
    } catch(err) { PutToDebugLogException(2, "common: Trim", err); }
    
    return str;
}

/** Helper function  which returns current browser name*/
var browserName = null; // browser family
var browserName2 = null; // browser name
function GetBrowser ()
{
    try{

    if (isNull(browserName) || isNull(browserName2))
    {
        var browser = navigator.userAgent.toLowerCase();
        
        PutToDebugLog(2, "EVENT, common: GetBrowser name: " + browser);

        // order is important here.  Safari userAgent contains mozilla,
        // IE 11 userAgent contains mozilla and netscape, 
        // and Chrome userAgent contains both mozilla and safari.
        if ((browser.indexOf('edge') !== -1))
        {
            browserName = 'Edge';
            browserName2 = 'Edge';
        }
        else if ((browser.indexOf('msie') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'MSIE';
            browserName2 = 'MSIE';
        }
        else if (browser.indexOf('trident') !== -1 || browser.indexOf('Trident') !== -1)
        {
            browserName = 'MSIE';
            browserName2 = 'MSIE';
        }
        else if (browser.indexOf('iphone') !== -1)
        {
            // this included both iPhone and iPad
            if (browser.indexOf('fxios') !== -1 || browser.indexOf('firefox') !== -1)
            {
                browserName2 = 'Firefox';
            }
            else if (browser.indexOf('crios') !== -1 || browser.indexOf('chrome') !== -1)
            {
                browserName2 = 'Chrome';
            }else
            {
                browserName2 = 'iPhone';
            }
            browserName = 'Netscape Family';
        }
        else if ((browser.indexOf('firefox') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'Netscape Family';
            browserName2 = 'Firefox';
        }
        else if (browser.indexOf('chrome') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Chrome';
        }
        else if (browser.indexOf('safari') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Safari';
        }
        else if ((browser.indexOf('mozilla') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'Netscape Family';
            browserName2 = 'Other';
        }
        else if (browser.indexOf('opera') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Opera';
        }else
        {
            browserName = '?';
            browserName2 = 'unknown';
        }
        
        PutToDebugLog(2, "EVENT, common: GetBrowser Detected browser name: " + browserName + ";  " + browserName2);
    }
    } catch(err) { PutToDebugLogException(2, "common: GetBrowser", err); }
    
    return browserName2;
}

/** helper functions: write logs to browser console*/
function PutToDebugLogException(level, msg, err) { PutToDebugLog(level, 'ERROR,' + msg + ' ' + err); }
function PutToDebugLog(level, msg)
{
    if (msg.indexOf("ERROR") > -1)
    {
        try { console.error(msg); } catch (e1) {  }
    }else
    {
        try { 
        //console.log(msg); 
        } catch (e2) {  }
    }
}