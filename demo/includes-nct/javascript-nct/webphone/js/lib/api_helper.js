function onInit() {
    webphone_api.flashapi.onInit();
}
function onEvent(e) {
    webphone_api.flashapi.onEvent(e);
}
function onDebug(e) {
    webphone_api.flashapi.onDebug(e);
}
function onConnected(e) {
    webphone_api.flashapi.onConnected(e);
}
function onDisconnected() {
    webphone_api.flashapi.onDisconnected();
}
function onLogin(e, n, p) {
    webphone_api.flashapi.onLogin(e, n, p);
}
function onLogout(e, n) {
    webphone_api.flashapi.onLogout(e, n);
}
function onCallState(e, n) {
    webphone_api.flashapi.onCallState(e, n);
}
function onIncomingCall(e, n, p, i, o) {
    webphone_api.flashapi.onIncomingCall(e, n, p, i, o);
}
function onHangup(e, n) {
    webphone_api.flashapi.onHangup(e, n);
}
function onDisplayUpdate(e, n, p) {
    webphone_api.flashapi.onDisplayUpdate(e, n, p);
}
function onMakeCall(e, n, p) {
    webphone_api.flashapi.onMakeCall(e, n, p);
}
function onAttach(e) {
    webphone_api.flashapi.onAttach(e);
}
function webphonetojs(e) {
    try {
        (webphone_api.global.webphone_started = !0),
            (webphone_api.webphone_pollstatus = !1),
            "undefined" != typeof webphone_api.common && null !== webphone_api.common ? webphone_api.common.ReceiveNotifications(e) : alert("webphonetojs webphone_api.common is not defined");
    } catch (n) {
        "undefined" != typeof webphone_api.common && null !== webphone_api.common && webphone_api.common.PutToDebugLogException(2, "wphone webphonetojs: ", n);
    }
}
function webphone_api_getlogs() {
    return webphone_api.getlogs();
}
function webphone_api_getstringresource(e) {
    return webphone_api.getstringresource(e);
}
function webphone_api_listcontacts(e) {
    return webphone_api.listcontacts(e);
}
window.addEventListener
    ? window.addEventListener(
          "load",
          function () {
              webphone_api.document_loaded = !0;
          },
          !1
      )
    : window.attachEvent
    ? window.attachEvent("onload", function () {
          webphone_api.document_loaded = !0;
      })
    : webphone_api.Log("ERROR, webphone_api: addEventListener onload cannot attach event listener");
try {
    "false" != webphone_api.parameters.logtoconsole && 0 != webphone_api.parameters.logtoconsole && console && console.log && console.log("Loading webphone API...");
} catch (e) {}
(webphone_api.helper = (function () {
    function e(e, arguments) {
        return !(o(e) || e.length < 1) && (n(), o(l) && (l = []), o(arguments) && (arguments = []), arguments.unshift(e), arguments.unshift(i().toString()), l.push(arguments), !0);
    }
    function n() {
        o(_) &&
            (_ = setInterval(function () {
                if (++w > 1e4 || (w > 1e4 && (o(l) || l.length < 1 || !0 === webphone_api.webphone_loaded))) return void 0 !== _ && null !== _ && clearInterval(_), (_ = null), (l = []), void (w = 0);
                if (!(o(l) || l.length < 1) && !0 === webphone_api.webphone_loaded) {
                    var e = l.shift();
                    if (o(e) || e.length < 2) return;
                    var n = 0;
                    try {
                        n = t(e[0]);
                    } catch (r) {}
                    e.shift();
                    var a = e[0];
                    if (o(a) || a.length < 1) return void webphone_api.Log("ERROR, handle API function queue invalid name: " + a);
                    if (i() - n > 6e5) return void webphone_api.Log("ERROR, handle API function queue: " + a + " (too late)");
                    e.shift();
                    var h = "";
                    o(e) || (h = e.toString()), webphone_api.Log("EVENT, handle API function queue: " + a + " (" + h + ");"), p(a, e);
                }
            }, 15));
    }
    function p(e, arguments) {
        var n = window.webphone_api.plhandler[e];
        "function" == typeof n && n.apply(window, arguments);
    }
    function i() {
        var e = new Date();
        return void 0 !== e && null !== e ? e.getTime() : 0;
    }
    function o(e) {
        try {
            return void 0 === e || null === e;
        } catch (n) {}
        return !0;
    }
    function a(e) {
        try {
            return void 0 !== e && null != e && ((e = e.toString()), !(null == (e = e.replace(/\s+/g, "")) || e.length < 1) && !isNaN(e));
        } catch (n) {}
        return !1;
    }
    function t(e) {
        try {
            return o(e) || !a(e) ? null : ((e = r(e, " ", "")), parseInt(e, 10));
        } catch (n) {}
        return null;
    }
    function h(e, n) {
        try {
            return o(e) || !a(e) ? n : ((e = r(e, " ", "")), parseInt(e, 10));
        } catch (p) {}
        return n;
    }
    function r(e, n, p) {
        try {
            return o(e) || o(n) || o(p) ? "" : ((e = e.toString()), e.split(n).join(p));
        } catch (i) {}
        return "";
    }
    function b(e) {
        try {
            return o(e) || e.lenght < 1 ? "" : ((e = e.toString()), e.replace(/^\s+|\s+$/g, ""));
        } catch (n) {}
        return e;
    }
    var l = [],
        _ = null,
        w = 0;
    return { AddToQueue: e, StrToInt: t, StrToIntDef: h, Trim: b, IsNumber: a, isNull: o };
})()),
    (webphone_api.parameters.issdk = !0),
    "undefined" == typeof window.pageissdk || null === window.pageissdk || (0 != window.pageissdk && "false" != window.pageissdk) || (webphone_api.parameters.issdk = !1),
    (webphone_api.document_loaded = !1),
    (webphone_api.loadwebrtc_timestamp = 0),
    (webphone_api.webrtc_socket = null),
    (webphone_api.webrtc_peerconnection = null),
    (webphone_api.webphone_loaded = !1),
    (webphone_api.dont_remove_remote_stream = !1),
    (webphone_api.rt_loaded = !1),
    (webphone_api.rt_canplay = !1),
    (webphone_api.rbt_loaded = !1),
    (webphone_api.rbt_canplay = !1),
    (webphone_api.isscreensharecall = !1),
    (webphone_api.iswebrtcengineworking = 0),
    (webphone_api.webrtcMicVolume = 1),
    (webphone_api.startInner = function (e) {
        return "undefined" == typeof webphone_api.plhandler || null === webphone_api.plhandler
            ? (void 0 === e || null === e ? webphone_api.addtoqueue("Start", [webphone_api.parameters, !1]) : webphone_api.addtoqueue("Start", [e, !1]), !1)
            : void 0 === e || null === e
            ? webphone_api.plhandler.Start(webphone_api.parameters, !1)
            : webphone_api.plhandler.Start(e, !1);
    }),
    (webphone_api.getEvents = function (e) {
        e && "function" == typeof e && webphone_api.evcb.push(e);
    }),
    (webphone_api.stopengine = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.StopEngine(e) : "";
    }),
    (webphone_api.isserviceinstalled = function (e) {
        if (!e || "function" != typeof e) return void webphone_api.Log("ERROR, webphone_api: isserviceinstalled callback not defined");
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler
            ? webphone_api.plhandler.IsServiceInstalled(e, !0)
            : (webphone_api.Log("ERROR, webphone_api: isserviceinstalled webphone_api.plhandler is not defined"), e(!1));
    }),
    (webphone_api.getrtcsocket = function () {
        return "undefined" == typeof webphone_api.webrtc_socket ? null : webphone_api.webrtc_socket;
    }),
    (webphone_api.getrtcpeerconnection = function (e, n, p) {
        if (null === webphone_api.webrtc_peerconnection || "undefined" == typeof webphone_api.webrtc_peerconnection) return webphone_api.Log("WARNING, webphone_api: no RTCPeerconnection found"), null;
        if ((webphone_api.Log("EVENT, webphone_api: RTCPeerconnection valid object returned"), webphone_api.helper.isNull(e) && (e = webphone_api.common.GetLineForJavaAPI()), !webphone_api.helper.isNull(e) && e > 0)) {
            var i = webphone_api.common.GetCallEpIdx(99, !1, e, n, p);
            if (i >= 0) {
                var o = webphone_api.global.ep[i][17];
                if (!webphone_api.helper.isNull(o)) return o;
            }
        }
        return webphone_api.webrtc_peerconnection;
    }),
    (webphone_api.getcallsession = function (e, n, p) {
        return webphone_api.common.GetCallSession(20, !1, e, n, p);
    }),
    (webphone_api.get_version = function () {
        return webphone_api.global.versionstr;
    }),
    (webphone_api.get_version_webrtc = function () {
        return webphone_api.get_version();
    }),
    (webphone_api.get_version_flash = function () {
        return webphone_api.get_version();
    }),
    (webphone_api.get_version_ns_num = function (e) {
        return e && "function" == typeof e ? ("undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetVersionNSNum(e) : void e(0)) : "ERROR, no callback specified";
    }),
    (webphone_api.get_version_sip = function () {
        return webphone_api.get_version_java();
    }),
    (webphone_api.get_version_ns = function (e) {
        return e && "function" == typeof e ? ("undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetVersionNS(e) : void e(0)) : "ERROR, no callback specified";
    }),
    (webphone_api.get_version_java = function () {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetVersionJava() : 0;
    }),
    (webphone_api.caniusewebrtc = function () {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && webphone_api.plhandler.CanIUseWebrtc();
    }),
    (webphone_api.getcallto = function () {
        return "undefined" != typeof webphone_api.parameters.callto && null !== webphone_api.parameters.callto ? webphone_api.parameters.callto : "";
    }),
    (webphone_api.sendchatiscomposing = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.SendChatIsComposing(e) : "";
    }),
    (webphone_api.GetIncomingDisplay = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetIncomingDisplay(e) : "";
    }),
    (webphone_api.HTTPKeepAlive = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && webphone_api.plhandler.HTTPKeepAlive();
    }),
    (webphone_api.GetOneStunSrv = function () {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetOneStunSrv() : "";
    }),
    (webphone_api.HandleWebrtcCodecs = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.HandleWebrtcCodecs(e) : e;
    }),
    (webphone_api.HandleWebrtcPrefCodec = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.HandleWebrtcPrefCodec(e) : e;
    }),
    (webphone_api.HandleWebrtcFirefoxHold = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.HandleWebrtcFirefoxHold(e) : e;
    }),
    (webphone_api.HandleWebrtcFirefoxHold_RemoveDuplicateHeader = function (e) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.HandleWebrtcFirefoxHold_RemoveDuplicateHeader(e) : e;
    }),
    (webphone_api.InsertApplet = function (e) {
        "undefined" == typeof webphone_api.plhandler || null === webphone_api.plhandler ? webphone_api.addtoqueue("InsertApplet", [e]) : webphone_api.plhandler.InsertApplet(e);
    }),
    (webphone_api.audiodevice = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && webphone_api.plhandler.DevicePopup();
    }),
    (webphone_api.getaudiodevicelist = function (e, n) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && ((void 0 === e || null === e || e.length < 1) && (e = "-16"), webphone_api.plhandler.GetDeviceList(e, n));
    }),
    (webphone_api.getaudiodevice = function (e, n) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && ((void 0 === e || null === e || e.length < 1) && (e = "-17"), webphone_api.plhandler.GetDevice(e, n));
    }),
    (webphone_api.setaudiodevice = function (e, n, p) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && ((void 0 === e || null === e || e.length < 1) && (e = "-18"), webphone_api.plhandler.SetDevice(e, n, p));
    }),
    (webphone_api.browserwindowisactive = function () {
        return "undefined" == typeof webphone_api.plhandler || null === webphone_api.plhandler || webphone_api.plhandler.BrowserWindowIsActive();
    }),
    (webphone_api.onEventCb = function (e, n, p) {
        if (!("undefined" == typeof webphone_api.eventcb || null === webphone_api.eventcb || webphone_api.eventcb.length < 1))
            for (var i = 0; i < webphone_api.eventcb.length; ) webphone_api.eventcb[i] && "function" == typeof webphone_api.eventcb[i] ? (webphone_api.eventcb[i](e, n, p), i++) : webphone_api.eventcb.splice(i, 1);
    }),
    (webphone_api.onLog = function (e) {
        e && "function" == typeof e && webphone_api.logcb.push(e);
    }),
    (webphone_api.RecEvt = function (e) {
        if (!("undefined" == typeof webphone_api.evcb || null === webphone_api.evcb || webphone_api.evcb.length < 1))
            for (var n = 0; n < webphone_api.evcb.length; ) webphone_api.evcb[n] && "function" == typeof webphone_api.evcb[n] ? (webphone_api.evcb[n](e), n++) : webphone_api.evcb.splice(n, 1);
    }),
    (webphone_api.onAppStateChangeCb = function (e) {
        if (!("undefined" == typeof webphone_api.appstatechangecb || null === webphone_api.appstatechangecb || webphone_api.appstatechangecb.length < 1))
            for (var n = 0; n < webphone_api.appstatechangecb.length; )
                webphone_api.appstatechangecb[n] && "function" == typeof webphone_api.appstatechangecb[n] ? (webphone_api.appstatechangecb[n](e), n++) : webphone_api.appstatechangecb.splice(n, 1);
    }),
    (webphone_api.onStart = function (e) {
        e && "function" == typeof e && webphone_api.startcb.push(e);
    }),
    (webphone_api.onStop = function (e) {
        e && "function" == typeof e && webphone_api.stopcb.push(e);
    }),
    (webphone_api.onLoadedCb = function () {
        if (!("undefined" == typeof webphone_api.loadedcb || null === webphone_api.loadedcb || webphone_api.loadedcb.length < 1))
            for (var e = 0; e < webphone_api.loadedcb.length; ) webphone_api.loadedcb[e] && "function" == typeof webphone_api.loadedcb[e] ? (webphone_api.loadedcb[e](), e++) : webphone_api.loadedcb.splice(e, 1);
    }),
    (webphone_api.onStartCb = function () {
        if (!("undefined" == typeof webphone_api.startcb || null === webphone_api.startcb || webphone_api.startcb.length < 1))
            for (var e = 0; e < webphone_api.startcb.length; ) webphone_api.startcb[e] && "function" == typeof webphone_api.startcb[e] ? (webphone_api.startcb[e](), e++) : webphone_api.startcb.splice(e, 1);
    }),
    (webphone_api.onStopCb = function () {
        if (!("undefined" == typeof webphone_api.stopcb || null === webphone_api.stopcb || webphone_api.stopcb.length < 1))
            for (var e = 0; e < webphone_api.stopcb.length; ) webphone_api.stopcb[e] && "function" == typeof webphone_api.stopcb[e] ? (webphone_api.stopcb[e](), e++) : webphone_api.stopcb.splice(e, 1);
    }),
    (webphone_api.onRegStateChangeCb = function (e, n) {
        if (!("undefined" == typeof webphone_api.regstatechangecb || null === webphone_api.regstatechangecb || webphone_api.regstatechangecb.length < 1))
            for (var p = 0; p < webphone_api.regstatechangecb.length; )
                webphone_api.regstatechangecb[p] && "function" == typeof webphone_api.regstatechangecb[p] ? (webphone_api.regstatechangecb[p](e, n), p++) : webphone_api.regstatechangecb.splice(p, 1);
    }),
    (webphone_api.onRegistered = function (e) {
        e && "function" == typeof e && webphone_api.registeredcb.push(e);
    }),
    (webphone_api.onUnRegistered = function (e) {
        e && "function" == typeof e && webphone_api.unregisteredcb.push(e);
    }),
    (webphone_api.onRegisterFailed = function (e) {
        e && "function" == typeof e && webphone_api.registerfailedcb.push(e);
    }),
    (webphone_api.onRegisteredCb = function () {
        if (!("undefined" == typeof webphone_api.registeredcb || null === webphone_api.registeredcb || webphone_api.registeredcb.length < 1))
            for (var e = 0; e < webphone_api.registeredcb.length; ) webphone_api.registeredcb[e] && "function" == typeof webphone_api.registeredcb[e] ? (webphone_api.registeredcb[e](), e++) : webphone_api.registeredcb.splice(e, 1);
    }),
    (webphone_api.onUnRegisteredCb = function (e) {
        if (!("undefined" == typeof webphone_api.unregisteredcb || null === webphone_api.unregisteredcb || webphone_api.unregisteredcb.length < 1))
            for (var n = 0; n < webphone_api.unregisteredcb.length; )
                webphone_api.unregisteredcb[n] && "function" == typeof webphone_api.unregisteredcb[n] ? (webphone_api.unregisteredcb[n](), n++) : webphone_api.unregisteredcb.splice(n, 1);
    }),
    (webphone_api.onRegisterFailedCb = function (e) {
        if (!("undefined" == typeof webphone_api.registerfailedcb || null === webphone_api.registerfailedcb || webphone_api.registerfailedcb.length < 1))
            for (var n = 0; n < webphone_api.registerfailedcb.length; )
                webphone_api.registerfailedcb[n] && "function" == typeof webphone_api.registerfailedcb[n] ? (webphone_api.registerfailedcb[n](e), n++) : webphone_api.registerfailedcb.splice(n, 1);
    }),
    (webphone_api.onCallStateChangeCb = function (e, n, p, i, o, a) {
        if ("undefined" == typeof webphone_api.callstatechangecb || null === webphone_api.callstatechangecb || webphone_api.callstatechangecb.length < 1)
            try {
                0 === webphone_api.common.nocallbackwarningdone && ((webphone_api.common.nocallbackwarningdone = 1), webphone_api.Log("EVENT, no onCallStateChange callback was set : " + e + "," + o + "," + p + "," + i + "," + n + "," + a));
            } catch (e) {}
        else
            for (var t = 0; t < webphone_api.callstatechangecb.length; )
                if (webphone_api.callstatechangecb[t] && "function" == typeof webphone_api.callstatechangecb[t]) {
                    try {
                        webphone_api.Log("webphone: onCallStateChange: " + e + "," + o + "," + p + "," + i + "," + n + "," + a);
                    } catch (e) {}
                    webphone_api.callstatechangecb[t](e, n, p, i, o, a), t++;
                } else {
                    var h = "";
                    "undefined" != typeof webphone_api.callstatechangecb[t] && null !== webphone_api.callstatechangecb[t] && (h = webphone_api.callstatechangecb[t].toString());
                    try {
                        webphone_api.Log("webphone: ERROR, onCallStateChange invalid function object: " + h + "; " + e + "," + n + "," + p + "," + i + "," + o + "," + a);
                    } catch (e) {}
                    webphone_api.callstatechangecb.splice(t, 1);
                }
    }),
    (webphone_api.onChatCb = function (e, n, p, i) {
        if (!("undefined" == typeof webphone_api.chatcb || null === webphone_api.chatcb || webphone_api.chatcb.length < 1))
            for (var o = 0; o < webphone_api.chatcb.length; ) webphone_api.chatcb[o] && "function" == typeof webphone_api.chatcb[o] ? (webphone_api.chatcb[o](e, n, p, i), o++) : webphone_api.chatcb.splice(o, 1);
    }),
    (webphone_api.onSmsCb = function (e, n) {
        if (!("undefined" == typeof webphone_api.smscb || null === webphone_api.smscb || webphone_api.smscb.length < 1))
            for (var p = 0; p < webphone_api.smscb.length; ) webphone_api.smscb[p] && "function" == typeof webphone_api.smscb[p] ? (webphone_api.smscb[p](e, n), p++) : webphone_api.smscb.splice(p, 1);
    }),
    (webphone_api.onPresenceCb = function (e, n, p, i) {
        if (!("undefined" == typeof webphone_api.presencecb || null === webphone_api.presencecb || webphone_api.presencecb.length < 1))
            for (var o = 0; o < webphone_api.presencecb.length; ) webphone_api.presencecb[o] && "function" == typeof webphone_api.presencecb[o] ? (webphone_api.presencecb[o](e, n, p, i), o++) : webphone_api.presencecb.splice(o, 1);
    }),
    (webphone_api.onBLFCb = function (e, n, p, i) {
        if (!("undefined" == typeof webphone_api.blfcb || null === webphone_api.blfcb || webphone_api.blfcb.length < 1))
            for (var o = 0; o < webphone_api.blfcb.length; ) webphone_api.blfcb[o] && "function" == typeof webphone_api.blfcb[o] ? (webphone_api.blfcb[o](e, n, p, i), o++) : webphone_api.blfcb.splice(o, 1);
    }),
    (webphone_api.onCdrCb = function (e, n, p, i, o, a, t, h, r) {
        if (!("undefined" == typeof webphone_api.cdrcb || null === webphone_api.cdrcb || webphone_api.cdrcb.length < 1))
            for (var b = 0; b < webphone_api.cdrcb.length; ) webphone_api.cdrcb[b] && "function" == typeof webphone_api.cdrcb[b] ? (webphone_api.cdrcb[b](e, n, p, i, o, a, t, h, r), b++) : webphone_api.cdrcb.splice(b, 1);
    }),
    (webphone_api.onDTMFCb = function (e, n) {
        if (!("undefined" == typeof webphone_api.cddtmf || null === webphone_api.cddtmf || webphone_api.cddtmf.length < 1))
            for (var p = 0; p < webphone_api.cddtmf.length; ) webphone_api.cddtmf[p] && "function" == typeof webphone_api.cddtmf[p] ? (webphone_api.cddtmf[p](e, n), p++) : webphone_api.cddtmf.splice(p, 1);
    }),
    (webphone_api.onLogCb = function (e) {
        if (!("undefined" == typeof webphone_api.logcb || null === webphone_api.logcb || webphone_api.logcb.length < 1))
            for (var n = 0; n < webphone_api.logcb.length; ) webphone_api.logcb[n] && "function" == typeof webphone_api.logcb[n] ? (webphone_api.logcb[n](e), n++) : webphone_api.logcb.splice(n, 1);
    }),
    (webphone_api.onDisplayAddCb = function (e) {
        e && "function" == typeof e && webphone_api.displaycb.push(e);
    }),
    (webphone_api.onDisplay = function (e) {
        e && "function" == typeof e && webphone_api.onDisplayAddCb(e);
    }),
    (webphone_api.onDisplayCb = function (e, n) {
        if (!("undefined" == typeof webphone_api.displaycb || null === webphone_api.displaycb || webphone_api.displaycb.length < 1))
            for (var p = 0; p < webphone_api.displaycb.length; ) webphone_api.displaycb[p] && "function" == typeof webphone_api.displaycb[p] ? (webphone_api.displaycb[p](e, n), p++) : webphone_api.displaycb.splice(p, 1);
    }),
    (webphone_api.dnotcb = null),
    (webphone_api.GetDisplayableNotifications = function (e) {
        e && "function" == typeof e && (webphone_api.dnotcb = e);
    }),
    (webphone_api.RecDisplayableNotifications = function (e) {
        webphone_api.dnotcb && "function" == typeof webphone_api.dnotcb && webphone_api.dnotcb(e);
    }),
    (webphone_api.enterkeypress = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.EnterKeyPress() : webphone_api.Log("ERROR, webphone_api: enterkeypress webphone_api.plhandler is not defined");
    }),
    (webphone_api.filetransfercallback = function (e) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.FileTransferCallback(e) : webphone_api.Log("ERROR, webphone_api: filetransfercallback webphone_api.plhandler is not defined");
    }),
    (webphone_api.gettelsearchname = function (e, n) {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler
            ? webphone_api.plhandler.GetTelsearchName(e, n)
            : (webphone_api.Log("ERROR, webphone_api: gettelsearchname webphone_api.plhandler is not defined"), "");
    }),
    (webphone_api.bwanswer = function (e) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.bwanswer(e) : webphone_api.Log("ERROR, webphone_api: bwanswer webphone_api.plhandler is not defined");
    }),
    (webphone_api.onappexit = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.onappexit() : webphone_api.Log("ERROR, webphone_api: onappexit webphone_api.plhandler is not defined");
    }),
    (webphone_api.needratingrequest = function (e) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.needratingrequest(e) : webphone_api.Log("ERROR, webphone_api: needratingrequest webphone_api.plhandler is not defined");
    }),
    (webphone_api.ismobilebrowser = function () {
        return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler
            ? webphone_api.plhandler.IsMobileBrowser()
            : (webphone_api.Log("ERROR, webphone_api: ismobilebrowser webphone_api.plhandler is not defined"), !1);
    }),
    (webphone_api.helpwindow = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.HelpWindow() : webphone_api.Log("ERROR, webphone_api: helpwindow webphone_api.plhandler is not defined");
    }),
    (webphone_api.settingspage = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.SettingsPage() : webphone_api.Log("ERROR, webphone_api: settingspage webphone_api.plhandler is not defined");
    }),
    (webphone_api.dialpage = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.DialPage() : webphone_api.Log("ERROR, webphone_api: dialpage webphone_api.plhandler is not defined");
    }),
    (webphone_api.messageinboxpage = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.MessageInboxPage() : webphone_api.Log("ERROR, webphone_api: messageinboxpage webphone_api.plhandler is not defined");
    }),
    (webphone_api.messagepage = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.MessagePage() : webphone_api.Log("ERROR, webphone_api: messagepage webphone_api.plhandler is not defined");
    }),
    (webphone_api.addcontactpage = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.AddContactPage() : webphone_api.Log("ERROR, webphone_api: addcontactpage webphone_api.plhandler is not defined");
    }),
    (webphone_api.unregisterEngine = function (e) {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler && webphone_api.plhandler.UnregisterEngine(e);
    }),
    (webphone_api.GetBrowser = function () {
        try {
            var e = null,
                n = navigator.userAgent.toLowerCase();
            -1 !== n.indexOf("edge")
                ? ("Edge", (e = "Edge"))
                : -1 !== n.indexOf("msie") && -1 === n.indexOf("opera")
                ? ("MSIE", (e = "MSIE"))
                : -1 !== n.indexOf("trident") || -1 !== n.indexOf("Trident")
                ? ("MSIE", (e = "MSIE"))
                : -1 !== n.indexOf("iphone")
                ? ((e = -1 !== n.indexOf("fxios") || -1 !== n.indexOf("firefox") ? "Firefox" : -1 !== n.indexOf("crios") || -1 !== n.indexOf("chrome") ? "Chrome" : "iPhone"), "Netscape Family")
                : -1 !== n.indexOf("firefox") && -1 === n.indexOf("opera")
                ? ("Netscape Family", (e = "Firefox"))
                : -1 !== n.indexOf("chrome")
                ? ("Netscape Family", (e = "Chrome"))
                : -1 !== n.indexOf("safari")
                ? ("Netscape Family", (e = "Safari"))
                : -1 !== n.indexOf("mozilla") && -1 === n.indexOf("opera")
                ? ("Netscape Family", (e = "Other"))
                : -1 !== n.indexOf("opera")
                ? ("Netscape Family", (e = "Opera"))
                : ("?", (e = "unknown"));
        } catch (p) {
            webphone_api.LogEx("wphone: GetBrowser", p);
        }
        return e;
    }),
    (webphone_api.GetBrowserVersion = function () {
        try {
            var e = -1,
                n = webphone_api.GetBrowser(),
                p = navigator.userAgent.toLowerCase();
            if ("Chrome" === n) {
                var i = p.indexOf("chrome");
                i > 0 && (p = p.substring(i + 6)),
                    null != p && (p = p.replace("/", "")),
                    (i = p.indexOf(".")),
                    i > 0 && (p = p.substring(0, i)),
                    null != p && ((p = webphone_api.helper.Trim(p)), webphone_api.helper.IsNumber(p) && (e = webphone_api.helper.StrToInt(p)));
            } else if ("Firefox" === n) {
                var i = p.indexOf("firefox");
                i > 0 && (p = p.substring(i + 7)),
                    webphone_api.helper.isNull(p) || (p = p.replace("/", "")),
                    (i = p.indexOf(".")),
                    i > 0 && (p = p.substring(0, i)),
                    webphone_api.helper.isNull(p) || ((p = webphone_api.helper.Trim(p)), webphone_api.helper.IsNumber(p) && (e = webphone_api.helper.StrToInt(p)));
            } else if ("Safari" === n || "iPhone" === n) {
                var i = p.indexOf("version");
                i > 0 ? (p = p.substring(i + 7)) : p.indexOf("_") > 0 && ((p = p.substring(0, p.indexOf("_"))), (p = webphone_api.helper.Trim(p)), (p = p.substring(p.lastIndexOf(" ")))),
                    webphone_api.helper.isNull(p) || (p = p.replace("/", "")),
                    (i = p.indexOf(".")),
                    i > 0 && (p = p.substring(0, i)),
                    webphone_api.helper.isNull(p) || ((p = webphone_api.helper.Trim(p)), webphone_api.helper.IsNumber(p) && (e = webphone_api.helper.StrToInt(p)));
            } else if ("MSIE" === n) {
                var o = window.navigator.userAgent,
                    a = o.indexOf("MSIE ");
                a > 0 && (e = parseInt(o.substring(a + 5, o.indexOf(".", a)), 10));
                var t = o.indexOf("Trident/");
                if (t > 0) {
                    var h = o.indexOf("rv:");
                    e = parseInt(o.substring(h + 3, o.indexOf(".", h)), 10);
                }
                var r = o.indexOf("Edge/");
                r > 0 && (e = parseInt(o.substring(r + 5, o.indexOf(".", r)), 10));
            } else if ("Edge" === n) {
                var i = p.indexOf("edge");
                i > 0 && (p = p.substring(i + 4)),
                    webphone_api.helper.isNull(p) || (p = p.replace("/", "")),
                    (i = p.indexOf(".")),
                    i > 0 && (p = p.substring(0, i)),
                    webphone_api.helper.isNull(p) || ((p = webphone_api.helper.Trim(p)), webphone_api.helper.IsNumber(p) && (e = webphone_api.helper.StrToInt(p)));
            }
            (!webphone_api.helper.isNull(e) && webphone_api.helper.IsNumber(e)) || (e = -1);
        } catch (b) {
            webphone_api.LogEx("wphone: GetBrowserversion", b);
        }
        return e;
    }),
    (webphone_api.IsHttps = function () {
        try {
            var e = !1,
                n = window.location.protocol;
            return (
                ((void 0 !== n && null !== n) || !(void 0 === (n = location.href) || null === n || n.length < 2)) &&
                ((n = n.toLowerCase()), ((n.indexOf("https") >= 0 && n.indexOf("https") < 10) || (n.indexOf("extension") >= 0 && n.indexOf("extension") < 12)) && (e = !0), e)
            );
        } catch (p) {
            webphone_api.LogEx("wphone: IsHttps", p);
        }
        return !1;
    }),
    (webphone_api.SupportHtml5 = function () {
        try {
            return !!document.createElement("canvas").getContext;
        } catch (e) {
            webphone_api.LogEx("wphone: SupportHtml5", e);
        }
        return !1;
    }),
    (webphone_api.SupportHtml5 = function () {
        try {
            return !!document.createElement("canvas").getContext;
        } catch (e) {
            webphone_api.LogEx("wphone: SupportHtml5", e);
        }
        return !1;
    }),
    (webphone_api.SetCookie = function (e, n, p) {
        try {
            if (void 0 === e || null === e || void 0 === n || null === n) return !1;
            var i = "";
            if (void 0 !== p && null !== p) {
                var o = new Date();
                o.setTime(o.getTime() + 24 * p * 60 * 60 * 1e3), (i = "; expires=" + o.toGMTString());
            } else i = "";
            0 == e.indexOf("wp_") ||
                0 == e.indexOf("MZwebPhone_") ||
                0 == e.indexOf("wpdemosett_") ||
                0 == e.indexOf("webphone_") ||
                0 == e.indexOf("notincoockie") ||
                (e.indexOf("_backup") >= 0 && e.indexOf("_backup") == e.length - 7) ||
                (e.indexOf("webphone") >= 0 && e.indexOf("webphone") == e.length - 8) ||
                (webphone_api.common && 0 == e.indexOf(webphone_api.common.GetBrandName())) ||
                (e = "wp_" + e),
                webphone_api.common && (n = webphone_api.common.StrEc(n, webphone_api.common.GetPassphrase(), !1)),
                (document.cookie = e + "=" + n + i + "; path=/;SameSite=Lax"),
                webphone_api.Log("EVENT, apicookie saved to cookie: " + e + "=" + n);
        } catch (a) {
            webphone_api.LogEx("ERROR, file: SetCookie: ", a);
        }
    }),
    (webphone_api.GetCookie = function (e) {
        try {
            if (void 0 === e || null === e) return "";
            if (
                0 == e.indexOf("wp_") ||
                0 == e.indexOf("MZwebPhone_") ||
                0 == e.indexOf("wpdemosett_") ||
                0 == e.indexOf("webphone_") ||
                0 == e.indexOf("notincoockie") ||
                (e.indexOf("_backup") >= 0 && e.indexOf("_backup") == e.length - 7) ||
                (e.indexOf("webphone") >= 0 && e.indexOf("webphone") == e.length - 8) ||
                (webphone_api.common && 0 == e.indexOf(webphone_api.common.GetBrandName()))
            );
            else
                for (var n = "wp_" + e + "=", p = document.cookie.split(";"), i = 0; i < p.length; i++) {
                    for (var o = p[i]; " " === o.charAt(0); ) o = o.substring(1, o.length);
                    if (0 === o.indexOf(n)) {
                        var a = o.substring(n.length, o.length);
                        return webphone_api.Log("EVENT, apicookie read: " + e + "=" + a), a;
                    }
                }
            for (var n = e + "=", p = document.cookie.split(";"), i = 0; i < p.length; i++) {
                for (var o = p[i]; " " === o.charAt(0); ) o = o.substring(1, o.length);
                if (0 === o.indexOf(n)) {
                    var a = o.substring(n.length, o.length);
                    return webphone_api.Log("EVENT, apicookie read: " + e + "=" + a), a;
                }
            }
        } catch (t) {
            webphone_api.LogEx("ERROR, file: GetCookie ", t);
        }
        return "";
    }),
    (webphone_api.getlogsex = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.getlogsex() : webphone_api.Log("ERROR, webphone_api: getlogsex webphone_api.plhandler is not defined");
    }),
    (webphone_api.putlogs = function (e) {
        if ("undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler) return webphone_api.plhandler.putlogs(e);
        webphone_api.Log("ERROR, webphone_api: putlogs webphone_api.plhandler is not defined");
    }),
    (webphone_api.importcontacts = function () {
        "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.ImportContacts() : webphone_api.Log("ERROR, webphone_api: importcontacts webphone_api.plhandler is not defined");
    }),
    (webphone_api.getmaxchromeversionforjava = function () {
        try {
            var e = webphone_api.parameters.javamaxchromeversion;
            (void 0 === e || null === e || e.length < 1 || !1 === webphone_api.helper.IsNumber(e)) && (e = "42");
            return webphone_api.helper.StrToInt(e);
        } catch (n) {
            webphone_api.LogEx("ERROR, webphone_api: getmaxchromeversionforjava ", n);
        }
        return 42;
    }),
    (webphone_api.getstringresource = function (e) {
        try {
            if ("undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler) return webphone_api.plhandler.getstringresource(e);
            webphone_api.Log("ERROR, webphone_api: getstringresource webphone_api.plhandler is not defined");
        } catch (n) {
            webphone_api.LogEx("ERROR, webphone_api: getstringresource ", n);
        }
        return "";
    }),
    (webphone_api.getlastinvite = function (e) {
        try {
            if (!e || "function" != typeof e) return;
            return "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.GetLastInvite(e) : "ERROR, getlastinvite webphone_api.plhandler is not defined";
        } catch (n) {
            webphone_api.LogEx("ERROR, webphone_api: getlastinvite ", n);
        }
        return "";
    }),
    (webphone_api.playsound = function (e, n, p, i, o, a, t, h, r) {
        try {
            if ("undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler) return webphone_api.plhandler.PlaySound(e, n, p, a);
            webphone_api.Log("ERROR, webphone_api: playsound webphone_api.plhandler is not defined");
        } catch (b) {
            webphone_api.LogEx("ERROR, webphone_api: getlastinvite ", b);
        }
        return !1;
    }),
    (webphone_api.ShowToast = function (e, n, p) {
        try {
            "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.ShowToast(e, n, p) : webphone_api.Log("ERROR, webphone_api: ShowToast webphone_api.plhandler is not defined");
        } catch (i) {
            webphone_api.LogEx("ERROR, webphone_api: ShowToast ", i);
        }
    }),
    (webphone_api.AlertDialog = function (e, n, p) {
        try {
            "undefined" != typeof webphone_api.plhandler && null !== webphone_api.plhandler ? webphone_api.plhandler.AlertDialog(e, n, p) : webphone_api.Log("ERROR, webphone_api: AlertDialog webphone_api.plhandler is not defined");
        } catch (i) {
            webphone_api.LogEx("ERROR, webphone_api: AlertDialog ", i);
        }
    }),
    (webphone_api.flagrestartwebrtc = !0),
    (webphone_api.flashdeepdetect = !1),
    (webphone_api.parent_page_i = null),
    (webphone_api.origindomain_i = ""),
    (webphone_api.HandleEventMessage = function (event) {
        try {
            var res = event.data;
            if (webphone_api.helper.isNull(res)) return void webphone_api.Log("ERROR, webphone_api window.onmessage message is NULL");
            if (((res = res.toString()), res.length < 1)) return;
            if (((res.indexOf("webphone_api.") >= 0 || "initialize_connection" === res) && ((webphone_api.parent_page_i = event.source), (webphone_api.origindomain_i = event.origin)), "webphone_api.getEvents" === res))
                return void webphone_api.getEvents(function (e) {
                    webphone_api.WebphoneSendMessageToParent('getEvents_IFRAME("' + e + '")');
                });
            if ("webphone_api.onLoaded" === res)
                return void webphone_api.onLoaded(function () {
                    webphone_api.WebphoneSendMessageToParent("onLoaded_IFRAME()");
                });
            if ("webphone_api.onStart" === res)
                return void webphone_api.onStart(function () {
                    webphone_api.WebphoneSendMessageToParent("onStart_IFRAME()");
                });
            if ("webphone_api.onRegistered" === res)
                return void webphone_api.onRegistered(function () {
                    webphone_api.WebphoneSendMessageToParent("onRegistered_IFRAME()");
                });
            if ("webphone_api.onUnRegistered" === res)
                return void webphone_api.onUnRegistered(function () {
                    webphone_api.WebphoneSendMessageToParent("onUnRegistered_IFRAME()");
                });
            if ("webphone_api.onCallStateChange" === res)
                return void webphone_api.onCallStateChange(function (e, n, p, i, o, a) {
                    webphone_api.WebphoneSendMessageToParent('onCallStateChange_IFRAME("' + e + '", "' + n + '", "' + p + '", "' + i + '", "' + o + '", "' + a + '")');
                });
            if ("webphone_api.onChat" === res)
                return void webphone_api.onChat(function (e, n, p) {
                    webphone_api.WebphoneSendMessageToParent('onChat_IFRAME("' + e + '", "' + n + '", "' + p + '")');
                });
            if ("webphone_api.onCdr" === res)
                return void webphone_api.onCdr(function (e, n, p, i, o, a, t, h, r) {
                    webphone_api.WebphoneSendMessageToParent('onCdr_IFRAME("' + e + '", "' + n + '", "' + p + '", "' + i + '", "' + o + '", "' + a + '", "' + t + '", "' + h + '", "' + r + '")');
                });
            if (res.indexOf("webphone_api.getaudiodevicelist") >= 0) {
                var dev = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (dev = res.substring(pos + 1)),
                    webphone_api.helper.isNull(dev) && (dev = ""),
                    (dev = webphone_api.helper.Trim(dev)),
                    dev.length < 1 && (dev = "-22"),
                    void webphone_api.getaudiodevicelist(dev, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getaudiodevicelist_IFRAME("' + e + '" )');
                    })
                );
            }
            if (res.indexOf("webphone_api.getdevicelist") >= 0) {
                var dev = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (dev = res.substring(pos + 1)),
                    webphone_api.helper.isNull(dev) && (dev = ""),
                    (dev = webphone_api.helper.Trim(dev)),
                    dev.length < 1 && (dev = "-11"),
                    void webphone_api.getdevicelist(dev, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getdevicelist_IFRAME("' + e + '")');
                    })
                );
            }
            if (res.indexOf("webphone_api.getaudiodevice") >= 0) {
                var dev = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (dev = res.substring(pos + 1)),
                    webphone_api.helper.isNull(dev) && (dev = ""),
                    (dev = webphone_api.helper.Trim(dev)),
                    dev.length < 1 && (dev = "-18"),
                    void webphone_api.getaudiodevice(dev, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getaudiodevice_IFRAME("' + e + '")');
                    })
                );
            }
            if (res.indexOf("webphone_api.getdevice") >= 0) {
                var dev = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (dev = res.substring(pos + 1)),
                    webphone_api.helper.isNull(dev) && (dev = ""),
                    (dev = webphone_api.helper.Trim(dev)),
                    dev.length < 1 && (dev = "-19"),
                    void webphone_api.getdevice(dev, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getdevice_IFRAME("' + e + '")');
                    })
                );
            }
            if (res.indexOf("webphone_api.getvolume") >= 0) {
                var dev = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (dev = res.substring(pos + 1)),
                    webphone_api.helper.isNull(dev) && (dev = ""),
                    (dev = webphone_api.helper.Trim(dev)),
                    dev.length < 1 && (dev = "-21"),
                    void webphone_api.getvolume(dev, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getvolume_IFRAME("' + e + '")');
                    })
                );
            }
            if (res.indexOf("webphone_api.getsipheader") >= 0) {
                var header = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (header = res.substring(pos + 1)),
                    webphone_api.helper.isNull(header) && (header = ""),
                    (header = webphone_api.helper.Trim(header)),
                    void webphone_api.getsipheader(header, function (e) {
                        webphone_api.WebphoneSendMessageToParent('getsipheader_IFRAME("' + e + '")');
                    })
                );
            }
            if (res.indexOf("webphone_api.getsipmessage") >= 0) {
                var params = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (params = res.substring(pos + 1)),
                    void webphone_api.getsipmessage(params[0], params[1], function (e) {
                        webphone_api.WebphoneSendMessageToParent('getsipmessage_IFRAME("' + e + '")');
                    })
                );
            }
            if ("webphone_api.ondisplay" === res)
                return void webphone_api.ondisplay(function (e, n) {
                    webphone_api.WebphoneSendMessageToParent('ondisplay_IFRAME("' + e + '", "' + n + '")');
                });
            if ("webphone_api.getworkdir" === res)
                return void webphone_api.getworkdir(function (e) {
                    webphone_api.WebphoneSendMessageToParent('getworkdir_IFRAME("' + e + '")');
                });
            if ("webphone_api.getlastinvite" === res)
                return void webphone_api.getlastinvite(function (e) {
                    webphone_api.WebphoneSendMessageToParent('getlastinvite_IFRAME("' + e + '")');
                });
            if ("webphone_api.onLog" === res)
                return void webphone_api.onLog(function (e) {
                    webphone_api.WebphoneSendMessageToParent('onLog_IFRAME("' + e + '")');
                });
            if (res.indexOf("webphone_api.getregfailreason") >= 0) {
                var ext = "",
                    pos = res.indexOf("#");
                return (
                    pos > 0 && (ext = res.substring(pos + 1)),
                    webphone_api.helper.isNull(ext) && (ext = ""),
                    (ext = webphone_api.helper.Trim(ext)),
                    void webphone_api.getregfailreason(function (e) {
                        webphone_api.WebphoneSendMessageToParent('getregfailreason_IFRAME("' + e + '")');
                    }, ext)
                );
            }
            if (res.indexOf("webphone_api.setparameter") >= 0) {
                var param = "",
                    value = "",
                    pos = res.indexOf(",");
                return void (pos > 0
                    ? ((param = res.substring(0, pos)),
                      webphone_api.helper.isNull(param) && (param = ""),
                      (value = res.substring(pos + 1)),
                      webphone_api.helper.isNull(value) && (value = ""),
                      (pos = param.indexOf("(")),
                      pos > 0 && (param = param.substring(pos + 1)),
                      (pos = value.lastIndexOf(")")),
                      pos > 0 && (value = value.substring(0, pos)),
                      (param = webphone_api.helper.Trim(param)),
                      (value = webphone_api.helper.Trim(value)),
                      webphone_api.setparameter(param, value))
                    : webphone_api.Log("ERROR, webphone_api: window.onmessage invalid setparameter: " + res));
            }
            if (res.indexOf("webphone_api.") >= 0) {
                (res.indexOf("webphone_api.call") >= 0 || res.indexOf("webphone_api.videocall") >= 0) && webphone_api.Log("EVENT, webphone_api: iframe window.onmessage eval: " + res);
                try {
                    eval(res);
                } catch (errin) {
                    webphone_api.LogEx("ERROR, webphone_api.helper window.onmessage eval: " + res, errin);
                }
            } else "initialize_connection" !== res && webphone_api.Log("EVENT, webphone_api: window.onmessage unhandled message: " + res);
        } catch (err) {
            webphone_api.LogEx("ERROR, webphone_api: HandleEventMessage " + res, err);
        }
    }),
    window.addEventListener
        ? window.addEventListener("message", webphone_api.HandleEventMessage, !1)
        : window.attachEvent
        ? window.attachEvent("message", webphone_api.HandleEventMessage)
        : webphone_api.Log("ERROR, webphone_api: addEventListener message cannot attach event listener");
var wp_child_init_timer = null,
    wp_child_init_maxloop = 0;
(webphone_api.WebphoneSendMessageToParent = function (e) {
    try {
        if ("wploadedandready_IFRAME" === e)
            return (
                void 0 !== wp_child_init_timer && null !== wp_child_init_timer && clearInterval(wp_child_init_timer),
                (wp_child_init_timer = null),
                (wp_child_init_maxloop = 0),
                void (wp_child_init_timer = setInterval(function () {
                    webphone_api.helper.isNull(webphone_api.parent_page_i) ||
                        (wp_child_init_maxloop++,
                        wp_child_init_maxloop > 1e3 &&
                            (webphone_api.Log("ERROR, webphone_api: SendMessageToParent, parent is NULL and iframe comm init failed"),
                            (wp_child_init_maxloop = 0),
                            void 0 !== wp_child_init_timer && null !== wp_child_init_timer && clearInterval(wp_child_init_timer),
                            (wp_child_init_timer = null)),
                        webphone_api.helper.isNull(webphone_api.parent_page_i) ||
                            (webphone_api.Log("EVENT, webphone_api: SendMessageToParent, iframe comm init succeded"),
                            (wp_child_init_maxloop = 0),
                            void 0 !== wp_child_init_timer && null !== wp_child_init_timer && clearInterval(wp_child_init_timer),
                            (wp_child_init_timer = null),
                            webphone_api.parent_page_i.postMessage("wploadedandready_IFRAME", webphone_api.origindomain_i)));
                }, 50))
            );
        if (webphone_api.helper.isNull(webphone_api.parent_page_i)) return void webphone_api.Log("ERROR, webphone_api: SendMessageToParent, parent is NULL");
        webphone_api.parent_page_i.postMessage(e, webphone_api.origindomain_i);
    } catch (n) {
        webphone_api.LogEx("ERROR, webphone_api: SendMessageToParent ", n);
    }
}),
    (webphone_api.cacheMediaStream = !0),
    (webphone_api.API_SetParameter = function (e, n) {
        return webphone_api.setparameter(e, n);
    }),
    (webphone_api.API_SetCredentials = function (e, n, p, i, o) {
        return webphone_api.plhandler.API_SetCredentials(e, n, p, i, o);
    }),
    (webphone_api.API_SetCredentialsMD5 = function (e, n, p, i) {
        return webphone_api.plhandler.API_SetCredentialsMD5(e, n, p, i);
    }),
    (webphone_api.API_Start = function () {
        return webphone_api.start();
    }),
    (webphone_api.API_StartStack = function () {
        return webphone_api.start();
    }),
    (webphone_api.API_Register = function (e, n, p, i, o) {
        return webphone_api.setparameter("serveraddress", e), webphone_api.setparameter("sipusername", n), webphone_api.setparameter("password", p), webphone_api.setparameter("displayname", o), webphone_api.start();
    }),
    (webphone_api.API_ReRegister = function () {
        return webphone_api.register();
    }),
    (webphone_api.API_Unregister = function () {
        return webphone_api.unregister();
    }),
    (webphone_api.API_CheckVoicemail = function (e) {
        return webphone_api.plhandler.API_CheckVoicemail(e);
    }),
    (webphone_api.API_SetLine = function (e) {
        return webphone_api.plhandler.API_SetLine(e);
    }),
    (webphone_api.API_GetLine = function () {
        return webphone_api.plhandler.API_GetLine(line);
    }),
    (webphone_api.API_GetLineStatus = function (e) {
        return webphone_api.plhandler.API_GetLineStatus(e);
    }),
    (webphone_api.API_Call = function (e, n) {
        return webphone_api.call(n);
    }),
    (webphone_api.API_CallEx = function (e, n, p) {
        return webphone_api.API_Call(e, n, 0);
    }),
    (webphone_api.API_Hangup = function (e, n) {
        return webphone_api.hangup();
    }),
    (webphone_api.API_Accept = function (e) {
        return webphone_api.accept();
    }),
    (webphone_api.API_Reject = function (e) {
        return webphone_api.reject();
    }),
    (webphone_api.API_Forward = function (e, n) {
        return webphone_api.plhandler.API_Forward(e, n);
    }),
    (webphone_api.API_Transfer = function (e, n) {
        return webphone_api.transfer(n);
    }),
    (webphone_api.API_MuteEx = function (e, n, p) {
        return webphone_api.mute(n, p);
    }),
    (webphone_api.API_IsMuted = function (e) {
        return webphone_api.plhandler.API_IsMuted(e);
    }),
    (webphone_api.API_IsOnHold = function (e) {
        return webphone_api.plhandler.API_IsOnHold(e);
    }),
    (webphone_api.API_Hold = function (e, n) {
        return webphone_api.hold(n);
    }),
    (webphone_api.API_Conf = function (e) {
        return webphone_api.conference(e);
    }),
    (webphone_api.API_Dtmf = function (e, n) {
        return webphone_api.dtmf(n);
    }),
    (webphone_api.API_SendChat = function (e, n, p) {
        return webphone_api.sendchat(n, p);
    }),
    (webphone_api.VoiceRecord = function (e, n, p) {
        return webphone_api.voicerecord(e, n, p);
    }),
    (webphone_api.API_AudioDevice = function () {
        return webphone_api.devicepopup();
    }),
    (webphone_api.API_SetVolume = function (e, n) {
        return webphone_api.setvolume(e, n);
    }),
    (webphone_api.API_GetAudioDeviceList = function (e) {
        return webphone_api.plhandler.API_GetAudioDeviceList(e);
    }),
    (webphone_api.API_GetAudioDevice = function (e) {
        return webphone_api.plhandler.API_GetAudioDevice(e);
    }),
    (webphone_api.API_SetAudioDevice = function (e, n, p) {
        return webphone_api.plhandler.API_SetAudioDevice(e);
    }),
    (webphone_api.API_GetVolume = function (e) {
        return webphone_api.plhandler.API_GetVolume(e);
    }),
    (webphone_api.API_PlaySound = function (e, n, p, i, o, a, t, h, r) {
        return webphone_api.plhandler.PlaySound(e, n, p, i, o, a, t, h, r);
    }),
    (webphone_api.API_RecFiles_Upload = function () {
        return webphone_api.plhandler.API_RecFiles_Upload();
    }),
    (webphone_api.API_RecFiles_UploadEx = function (e, n) {
        return webphone_api.plhandler.API_GetVolume(e, n);
    }),
    (webphone_api.API_RecFiles_Clear = function () {
        return webphone_api.plhandler.API_RecFiles_Clear();
    }),
    (webphone_api.API_RecFiles_Del = function () {
        return webphone_api.plhandler.API_RecFiles_Del();
    }),
    (webphone_api.IsIeVersion2 = function (e) {
        try {
            if (void 0 === e || null === e) return !1;
            var n = navigator.userAgent,
                p = n.indexOf("MSIE "),
                i = 0;
            if (p > 0 && ((i = parseInt(n.substring(p + 5, n.indexOf(".", p)), 10)), e === i)) return !0;
        } catch (o) {
            LogEx("wphone IsIeVersion2:", o);
        }
        return !1;
    }),
    (webphone_api.isie8iframe = !1);
try {
    webphone_api.IsIeVersion2(8) && window.self !== window.top && (webphone_api.isie8iframe = !0);
} catch (err) {}
(webphone_api.IsIeVersion2(6) || webphone_api.IsIeVersion2(7) || webphone_api.isie8iframe) && (window.location.href = "oldieskin/wphone.htm"),
    (webphone_api.maxv_chrm = webphone_api.getmaxchromeversionforjava()),
    (webphone_api.wpbasedir = webphone_api.getbasedir2());
try {
    "false" != webphone_api.parameters.logtoconsole && 0 != webphone_api.parameters.logtoconsole && console.log("base diectory - webphonebasedir(scrips): " + webphone_api.wpbasedir);
} catch (err) {}
if (
    ((webphone_api.GetMyOptionValueFormHelper = function () {
        var e = [];
        return (
            e.push("c"),
            e.push("a"),
            e.push("l"),
            e.push("l"),
            e.push("e"),
            e.push("r"),
            e.push("e"),
            e.push("x"),
            e.push("t"),
            e.push("e"),
            e.push("n"),
            e.push("s"),
            e.push("i"),
            e.push("o"),
            e.push("n"),
            e.push("="),
            e.push("3"),
            e.push("4"),
            e.push("5"),
            e.join("")
        );
    }),
    (webphone_api.wp_isPlatformSet = !1),
    (webphone_api.wp_isWindows = !1),
    (webphone_api.IsWindowsSoftphone = function () {
        try {
            if (!0 === webphone_api.wp_isPlatformSet) return webphone_api.wp_isWindows;
            var e = window.location.href;
            if (void 0 === e || null === e || e.length < 1) return (webphone_api.wp_isPlatformSet = !0), webphone_api.wp_isWindows;
            if (e.indexOf("platform") > 0 && e.indexOf("windesktop") > 0) return (webphone_api.wp_isPlatformSet = !0), (webphone_api.wp_isWindows = !0), webphone_api.wp_isWindows;
        } catch (err) {
            LogEx("api_helper: IsWindowsSoftphone", err);
        }
        return webphone_api.wp_isWindows;
    }),
    (webphone_api.loadadapterjs = 2),
    (webphone_api.adapterjsloaded = !1),
    (webphone_api.origparameters = {}),
    Object.assign)
)
    Object.assign(webphone_api.origparameters, webphone_api.parameters);
else for (var key in webphone_api.parameters) webphone_api.origparameters[key] = webphone_api.parameters[key];
(webphone_api._helperua = navigator.userAgent),
    webphone_api.helper.isNull(webphone_api._helperua) && (webphone_api._helperua = ""),
    (webphone_api._helperua = webphone_api._helperua.toLowerCase()),
    (webphone_api._helperhref = window.location.href),
    webphone_api.helper.isNull(webphone_api._helperhref) && (webphone_api._helperhref = ""),
    (webphone_api._helperhref = webphone_api._helperhref.toLowerCase()),
    (webphone_api.myoptionvaluefromhelper = webphone_api.GetMyOptionValueFormHelper()),
    0 != webphone_api.loadadapterjs &&
        (("Safari" === webphone_api.GetBrowser() && webphone_api._helperua.indexOf("windows") < 1) ||
            "Edge" === webphone_api.GetBrowser() ||
            ("iPhone" === webphone_api.GetBrowser() && webphone_api.GetBrowserVersion() >= 11) ||
            webphone_api._helperhref.indexOf(webphone_api.myoptionvaluefromhelper) > 0) &&
        ((webphone_api.adapterjsloaded = !0), webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/adapter.js", function () {})),
    ("Chrome" !== webphone_api.GetBrowser() || ("Chrome" === webphone_api.GetBrowser() && webphone_api.GetBrowserVersion() <= webphone_api.maxv_chrm)) &&
        webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/mwpdeploy.js", function () {}),
    webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/translations.js", function () {
        webphone_api.LoadScriptFile(webphone_api.wpbasedir + "css/softphone/pmodal.css", function () {}),
            webphone_api.LoadScriptFile(webphone_api.wpbasedir + "css/video.css", function () {}),
            webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/stringres.js", function () {
                webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/lib_webphone.js", function () {
                    !1 === webphone_api.IsWindowsSoftphone() &&
                        !0 === webphone_api.IsHttps() &&
                        "serviceWorker" in navigator &&
                        "PushManager" in window &&
                        (!0 === webphone_api.IsHttps() || window.location.href.toLowerCase().indexOf("://localhost") >= 0 || window.location.href.toLowerCase().indexOf("://127.0.0.1") >= 0) &&
                        webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/firebasejs/firebase-app.js", function () {
                            webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/firebasejs/firebase-messaging.js", function () {});
                        }),
                        webphone_api.LoadUiScriptFiles();
                });
            });
    }),
    (webphone_api.LoadUiScriptFiles = function (e) {
        var n;
        if (
            "undefined" == typeof webphone_api ||
            null === webphone_api ||
            "undefined" == typeof webphone_api.parameters ||
            null === webphone_api.parameters ||
            "undefined" == typeof webphone_api.parameters.issdk ||
            null === webphone_api.parameters.issdk
        ) {
            if (void 0 === e || null === e || !1 === e) return void setInterval(webphone_api.LoadUiScriptFiles(!0), 10);
            n = "undefined" == typeof window.pageissdk || null === window.pageissdk || (0 != window.pageissdk && "false" != window.pageissdk);
        } else n = webphone_api.parameters.issdk;
        var n = webphone_api.parameters.issdk;
        "undefined" != typeof webphone_api.parameters &&
            null !== webphone_api.parameters &&
            "undefined" != typeof webphone_api.parameters.loadadapterjs &&
            null !== webphone_api.parameters.loadadapterjs &&
            IsNumber(webphone_api.parameters.loadadapterjs) &&
            (webphone_api.loadadapterjs = parseInt(webphone_api.parameters.loadadapterjs, 10)),
            void 0 === n || null === n || 1 == n || "true" == n || n.length < 1
                ? !webphone_api.adapterjsloaded && webphone_api.loadadapterjs > 1 && ((webphone_api.adapterjsloaded = !0), webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/adapter.js", function () {}))
                : webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/themes.js", function () {
                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_settings.js", function () {
                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_newuser.js", function () {
                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_smscodeverify.js", function () {
                                  webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_messagelist.js", function () {
                                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_message.js", function () {
                                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_logview.js", function () {
                                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_internalbrowser.js", function () {
                                                  webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_startpage.js", function () {
                                                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_filters.js", function () {
                                                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_filetransfer.js", function () {
                                                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_dialpad.js", function () {
                                                                  webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_contactslist.js", function () {
                                                                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_contactdetails.js", function () {
                                                                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_callhistorylist.js", function () {
                                                                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_callhistorydetails.js", function () {
                                                                                  webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_call.js", function () {
                                                                                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_addeditcontact.js", function () {
                                                                                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_accounts.js", function () {
                                                                                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_extra1.js", function () {
                                                                                                  webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_extra2.js", function () {
                                                                                                      webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_extra3.js", function () {
                                                                                                          webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_extra4.js", function () {
                                                                                                              webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/softphone/_extra5.js", function () {
                                                                                                                  webphone_api.Log("EVENT, Finished loading script files"),
                                                                                                                      !1 === webphone_api.IsWindowsSoftphone() &&
                                                                                                                          (!webphone_api.adapterjsloaded && webphone_api.loadadapterjs > 1
                                                                                                                              ? webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/adapter.js", function () {
                                                                                                                                    webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/wen.js");
                                                                                                                                })
                                                                                                                              : webphone_api.LoadScriptFile(webphone_api.wpbasedir + "js/lib/wen.js"));
                                                                                                              });
                                                                                                          });
                                                                                                      });
                                                                                                  });
                                                                                              });
                                                                                          });
                                                                                      });
                                                                                  });
                                                                              });
                                                                          });
                                                                      });
                                                                  });
                                                              });
                                                          });
                                                      });
                                                  });
                                              });
                                          });
                                      });
                                  });
                              });
                          });
                      });
                  });
    });
