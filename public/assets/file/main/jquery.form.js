﻿/*
 * jQuery Form Plugin
 * version: 3.43.0-2013.09.03
 * Requires jQuery v1.5 or later
 * Copyright (c) 2013 M. Alsup
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Project repository: https://github.com/malsup/form
 * Dual licensed under the MIT and GPL licenses.
 * https://github.com/malsup/form#copyright-and-license
 */
(function(a){var d={};d.fileapi=a("<input type='file'/>").get(0).files!==undefined;d.formdata=window.FormData!==undefined;var e=!!a.fn.prop;a.fn.attr2=function(){if(!e){return this.attr.apply(this,arguments)}var g=this.prop.apply(this,arguments);if((g&&g.jquery)||typeof g==="string"){return g}return this.attr.apply(this,arguments)};a.fn.ajaxSubmit=function(B){if(!this.length){f("ajaxSubmit: skipping submit process - no element selected");return this}var v,i,G,g=this;if(typeof B=="function"){B={success:B}}else{if(B===undefined){B={}}}v=B.type||this.attr2("method");i=B.url||this.attr2("action");G=(typeof i==="string")?a.trim(i):"";G=G||window.location.href||"";if(G){G=(G.match(/^([^#]+)/)||[])[1]}B=a.extend(true,{url:G,success:a.ajaxSettings.success,type:v||a.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},B);var H={};this.trigger("form-pre-serialize",[this,B,H]);if(H.veto){f("ajaxSubmit: submit vetoed via form-pre-serialize trigger");return this}if(B.beforeSerialize&&B.beforeSerialize(this,B)===false){f("ajaxSubmit: submit aborted via beforeSerialize callback");return this}var F=B.traditional;if(F===undefined){F=a.ajaxSettings.traditional}var m=[];var D,h=this.formToArray(B.semantic,m);if(B.data){B.extraData=B.data;D=a.param(B.data,F)}if(B.beforeSubmit&&B.beforeSubmit(h,this,B)===false){f("ajaxSubmit: submit aborted via beforeSubmit callback");return this}this.trigger("form-submit-validate",[h,this,B,H]);if(H.veto){f("ajaxSubmit: submit vetoed via form-submit-validate trigger");return this}var C=a.param(h,F);if(C==""){C="validate_post_method=293503707045"}if(D){C=(C?(C+"&"+D):D)}if(B.type.toUpperCase()=="GET"){B.url+=(B.url.indexOf("?")>=0?"&":"?")+C;B.data=null}else{B.data=C}var j=[];if(B.resetForm){j.push(function(){g.resetForm()})}if(B.clearForm){j.push(function(){g.clearForm(B.includeHidden)})}if(!B.dataType&&B.target){var A=B.success||function(){};j.push(function(k){var q=B.replaceTarget?"replaceWith":"html";a(B.target)[q](k).each(A,arguments)})}else{if(B.success){j.push(B.success)}}B.success=function(q,K,L){var k=B.context||this;for(var I=0,J=j.length;I<J;I++){j[I].apply(k,[q,K,L||g,g])}};if(B.error){var z=B.error;B.error=function(J,I,q){var k=B.context||this;z.apply(k,[J,I,q,g])}}if(B.complete){var y=B.complete;B.complete=function(I,q){var k=B.context||this;y.apply(k,[I,q,g])}}var o=a("input[type=file]:enabled",this).filter(function(){return a(this).val()!=""});var s=o.length>0;var w="multipart/form-data";var x=(g.attr("enctype")==w||g.attr("encoding")==w);var n=d.fileapi&&d.formdata;f("fileAPI :"+n);var E=(s||x)&&!n;var t;if(B.iframe!==false&&(B.iframe||E)){if(B.closeKeepAlive){a.get(B.closeKeepAlive,function(){t=p(h)})}else{t=p(h)}}else{if((s||x)&&n){t=r(h)}else{t=a.ajax(B)}}g.removeData("jqxhr").data("jqxhr",t);for(var u=0;u<m.length;u++){m[u]=null}this.trigger("form-submit-notify",[this,B]);return this;function l(k){var L=a.param(k,B.traditional).split("&");var I=L.length;var K=[];var q,J;for(q=0;q<I;q++){L[q]=L[q].replace(/\+/g," ");J=L[q].split("=");K.push([decodeURIComponent(J[0]),decodeURIComponent(J[1])])}return K}function r(k){var I=new FormData();for(var J=0;J<k.length;J++){I.append(k[J].name,k[J].value)}if(B.extraData){var L=l(B.extraData);for(J=0;J<L.length;J++){if(L[J]){I.append(L[J][0],L[J][1])}}}B.data=null;var K=a.extend(true,{},a.ajaxSettings,B,{contentType:false,processData:false,cache:false,type:v||"POST"});if(B.uploadProgress){K.xhr=function(){var M=a.ajaxSettings.xhr();if(M.upload){M.upload.addEventListener("progress",function(N){var O=0;var P=N.loaded||N.position;var Q=N.total;if(N.lengthComputable){O=Math.ceil(P/Q*100)}B.uploadProgress(N,P,Q,O)},false)}return M}}K.data=null;var q=K.beforeSend;K.beforeSend=function(N,M){M.data=I;if(q){q.call(this,N,M)}};return a.ajax(K)}function p(q){var T=g[0],S,X,ac,U,Y,k,Z,ai,ae,aa,af,ag;var O=a.Deferred();O.abort=function(aj){ai.abort(aj)};if(q){for(X=0;X<m.length;X++){S=a(m[X]);if(e){S.prop("disabled",false)}else{S.removeAttr("disabled")}}}ac=a.extend(true,{},a.ajaxSettings,B);ac.context=ac.context||ac;Y="jqFormIO"+(new Date().getTime());if(ac.iframeTarget){k=a(ac.iframeTarget);aa=k.attr2("name");if(!aa){k.attr2("name",Y)}else{Y=aa}}else{k=a('<iframe name="'+Y+'" src="'+ac.iframeSrc+'" />');k.css({position:"absolute",top:"-1000px",left:"-1000px"})}Z=k[0];ai={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(al){var aj=(al==="timeout"?"timeout":"aborted");f("aborting upload... "+aj);this.aborted=1;try{if(Z.contentWindow.document.execCommand){Z.contentWindow.document.execCommand("Stop")}}catch(ak){}k.attr("src",ac.iframeSrc);ai.error=aj;if(ac.error){ac.error.call(ac.context,ai,aj,al)}if(U){a.event.trigger("ajaxError",[ai,ac,aj])}if(ac.complete){ac.complete.call(ac.context,ai,aj)}}};U=ac.global;if(U&&0===a.active++){a.event.trigger("ajaxStart")}if(U){a.event.trigger("ajaxSend",[ai,ac])}if(ac.beforeSend&&ac.beforeSend.call(ac.context,ai,ac)===false){if(ac.global){a.active--}O.reject();return O}if(ai.aborted){O.reject();return O}ae=T.clk;if(ae){aa=ae.name;if(aa&&!ae.disabled){ac.extraData=ac.extraData||{};ac.extraData[aa]=ae.value;if(ae.type=="image"){ac.extraData[aa+".x"]=T.clk_x;ac.extraData[aa+".y"]=T.clk_y}}}var K=1;var ad=2;function V(al){var aj=null;try{if(al.contentWindow){aj=al.contentWindow.document}}catch(ak){f("cannot get iframe.contentWindow document: "+ak)}if(aj){return aj}try{aj=al.contentDocument?al.contentDocument:al.document}catch(ak){f("cannot get iframe.contentDocument: "+ak);aj=al.document}return aj}var M=a("meta[name=csrf-token]").attr("content");var L=a("meta[name=csrf-param]").attr("content");if(L&&M){ac.extraData=ac.extraData||{};ac.extraData[L]=M}function R(){var ap=g.attr2("target"),aj=g.attr2("action");T.setAttribute("target",Y);if(!v||/post/i.test(v)){T.setAttribute("method","POST")}if(aj!=ac.url){T.setAttribute("action",ac.url)}if(!ac.skipEncodingOverride&&(!v||/post/i.test(v))){g.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"})}if(ac.timeout){ag=setTimeout(function(){af=true;J(K)},ac.timeout)}function ak(){try{var ar=V(Z).readyState;f("state = "+ar);if(ar&&ar.toLowerCase()=="uninitialized"){setTimeout(ak,50)}}catch(aq){f("Server abort: ",aq," (",aq.name,")");J(ad);if(ag){clearTimeout(ag)}ag=undefined}}var am=[];try{if(ac.extraData){for(var an in ac.extraData){if(ac.extraData.hasOwnProperty(an)){if(a.isPlainObject(ac.extraData[an])&&ac.extraData[an].hasOwnProperty("name")&&ac.extraData[an].hasOwnProperty("value")){am.push(a('<input type="hidden" name="'+ac.extraData[an].name+'">').val(ac.extraData[an].value).appendTo(T)[0])}else{am.push(a('<input type="hidden" name="'+an+'">').val(ac.extraData[an]).appendTo(T)[0])}}}}if(!ac.iframeTarget){k.appendTo("body")}if(Z.attachEvent){Z.attachEvent("onload",J)}else{Z.addEventListener("load",J,false)}setTimeout(ak,15);try{T.submit()}catch(al){var ao=document.createElement("form").submit;ao.apply(T)}}finally{T.setAttribute("action",aj);if(ap){T.setAttribute("target",ap)}else{g.removeAttr("target")}a(am).remove()}}if(ac.forceSync){R()}else{setTimeout(R,10)}var N,P,Q=50,I;function J(am){if(ai.aborted||I){return}P=V(Z);if(!P){f("cannot access response document");am=ad}if(am===K&&ai){ai.abort("timeout");O.reject(ai,"timeout");return}else{if(am==ad&&ai){ai.abort("server abort");O.reject(ai,"error","server abort");return}}if(!P||P.location.href==ac.iframeSrc){if(!af){return}}if(Z.detachEvent){Z.detachEvent("onload",J)}else{Z.removeEventListener("load",J,false)}var at="success",ao;try{if(af){throw"timeout"}var ap=ac.dataType=="xml"||P.XMLDocument||a.isXMLDoc(P);f("isXml="+ap);if(!ap&&window.opera&&(P.body===null||!P.body.innerHTML)){if(--Q){f("requeing onLoad callback, DOM not available");setTimeout(J,250);return}}var ak=P.body?P.body:P.documentElement;ai.responseText=ak?ak.innerHTML:null;ai.responseXML=P.XMLDocument?P.XMLDocument:P;if(ap){ac.dataType="xml"}ai.getResponseHeader=function(av){var aw={"content-type":ac.dataType};return aw[av.toLowerCase()]};if(ak){ai.status=Number(ak.getAttribute("status"))||ai.status;ai.statusText=ak.getAttribute("statusText")||ai.statusText}var al=(ac.dataType||"").toLowerCase();var ar=/(json|script|text)/.test(al);if(ar||ac.textarea){var au=P.getElementsByTagName("textarea")[0];if(au){ai.responseText=au.value;ai.status=Number(au.getAttribute("status"))||ai.status;ai.statusText=au.getAttribute("statusText")||ai.statusText}else{if(ar){var aq=P.getElementsByTagName("pre")[0];var aj=P.getElementsByTagName("body")[0];if(aq){ai.responseText=aq.textContent?aq.textContent:aq.innerText}else{if(aj){ai.responseText=aj.textContent?aj.textContent:aj.innerText}}}}}else{if(al=="xml"&&!ai.responseXML&&ai.responseText){ai.responseXML=ah(ai.responseText)}}try{N=W(ai,al,ac)}catch(an){at="parsererror";ai.error=ao=(an||at)}}catch(an){f("error caught: ",an);at="error";ai.error=ao=(an||at)}if(ai.aborted){f("upload aborted");at=null}if(ai.status){at=(ai.status>=200&&ai.status<300||ai.status===304)?"success":"error"}if(at==="success"){if(ac.success){ac.success.call(ac.context,N,"success",ai)}O.resolve(ai.responseText,"success",ai);if(U){a.event.trigger("ajaxSuccess",[ai,ac])}}else{if(at){if(ao===undefined){ao=ai.statusText}if(ac.error){ac.error.call(ac.context,ai,at,ao)}O.reject(ai,"error",ao);if(U){a.event.trigger("ajaxError",[ai,ac,ao])}}}if(U){a.event.trigger("ajaxComplete",[ai,ac])}if(U&&!--a.active){a.event.trigger("ajaxStop")}if(ac.complete){ac.complete.call(ac.context,ai,at)}I=true;if(ac.timeout){clearTimeout(ag)}setTimeout(function(){if(!ac.iframeTarget){k.remove()}else{k.attr("src",ac.iframeSrc)}ai.responseXML=null},100)}var ah=a.parseXML||function(ak,aj){if(window.ActiveXObject){aj=new ActiveXObject("Microsoft.XMLDOM");aj.async="false";aj.loadXML(ak)}else{aj=(new DOMParser()).parseFromString(ak,"text/xml")}return(aj&&aj.documentElement&&aj.documentElement.nodeName!="parsererror")?aj:null};var ab=a.parseJSON||function(aj){return window["eval"]("("+aj+")")};var W=function(an,am,al){var aj=an.getResponseHeader("content-type")||"",ao=am==="xml"||!am&&aj.indexOf("xml")>=0,ak=ao?an.responseXML:an.responseText;if(ao&&ak.documentElement.nodeName==="parsererror"){if(a.error){a.error("parsererror")}}if(al&&al.dataFilter){ak=al.dataFilter(ak,am)}if(typeof ak==="string"){if(am==="json"||!am&&aj.indexOf("json")>=0){ak=ab(ak)}else{if(am==="script"||!am&&aj.indexOf("javascript")>=0){a.globalEval(ak)}}}return ak};return O}};a.fn.ajaxForm=function(h){h=h||{};h.delegation=h.delegation&&a.isFunction(a.fn.on);if(!h.delegation&&this.length===0){var g={s:this.selector,c:this.context};if(!a.isReady&&g.s){f("DOM not ready, queuing ajaxForm");a(function(){a(g.s,g.c).ajaxForm(h)});return this}f("terminating; zero elements found by selector"+(a.isReady?"":" (DOM not ready)"));return this}if(h.delegation){a(document).off("submit.form-plugin",this.selector,c).off("click.form-plugin",this.selector,b).on("submit.form-plugin",this.selector,h,c).on("click.form-plugin",this.selector,h,b);return this}return this.ajaxFormUnbind().bind("submit.form-plugin",h,c).bind("click.form-plugin",h,b)};function c(g){var h=g.data;if(!g.isDefaultPrevented()){g.preventDefault();a(this).ajaxSubmit(h)}}function b(h){var l=h.target;var g=a(l);if(!(g.is("[type=submit],[type=image]"))){var k=g.closest("[type=submit]");if(k.length===0){return}l=k[0]}var i=this;i.clk=l;if(l.type=="image"){if(h.offsetX!==undefined){i.clk_x=h.offsetX;i.clk_y=h.offsetY}else{if(typeof a.fn.offset=="function"){var j=g.offset();i.clk_x=h.pageX-j.left;i.clk_y=h.pageY-j.top}else{i.clk_x=h.pageX-l.offsetLeft;i.clk_y=h.pageY-l.offsetTop}}}setTimeout(function(){i.clk=i.clk_x=i.clk_y=null},100)}a.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")};a.fn.formToArray=function(x,l){var h=[];if(this.length===0){return h}var p=this[0];var m=x?p.getElementsByTagName("*"):p.elements;if(!m){return h}var q,s,w,y,k,u,t;for(q=0,u=m.length;q<u;q++){k=m[q];w=k.name;if(!w||k.disabled){continue}if(x&&p.clk&&k.type=="image"){if(p.clk==k){h.push({name:w,value:a(k).val(),type:k.type});h.push({name:w+".x",value:p.clk_x},{name:w+".y",value:p.clk_y})}continue}y=a.fieldValue(k,true);if(y&&y.constructor==Array){if(l){l.push(k)}for(s=0,t=y.length;s<t;s++){h.push({name:w,value:y[s]})}}else{if(d.fileapi&&k.type=="file"){if(l){l.push(k)}var o=k.files;if(o.length){for(s=0;s<o.length;s++){h.push({name:w,value:o[s],type:k.type})}}else{h.push({name:w,value:"",type:k.type})}}else{if(y!==null&&typeof y!="undefined"){if(l){l.push(k)}h.push({name:w,value:y,type:k.type,required:k.required})}}}}if(!x&&p.clk){var g=a(p.clk),r=g[0];w=r.name;if(w&&!r.disabled&&r.type=="image"){h.push({name:w,value:g.val()});h.push({name:w+".x",value:p.clk_x},{name:w+".y",value:p.clk_y})}}return h};a.fn.formSerialize=function(g){return a.param(this.formToArray(g))};a.fn.fieldSerialize=function(h){var g=[];this.each(function(){var l=this.name;if(!l){return}var m=a.fieldValue(this,h);if(m&&m.constructor==Array){for(var j=0,k=m.length;j<k;j++){g.push({name:l,value:m[j]})}}else{if(m!==null&&typeof m!="undefined"){g.push({name:this.name,value:m})}}});return a.param(g)};a.fn.fieldValue=function(k){for(var m=[],h=0,j=this.length;h<j;h++){var g=this[h];var l=a.fieldValue(g,k);if(l===null||typeof l=="undefined"||(l.constructor==Array&&!l.length)){continue}if(l.constructor==Array){a.merge(m,l)}else{m.push(l)}}return m};a.fieldValue=function(h,r){var m=h.name,s=h.type,u=h.tagName.toLowerCase();if(r===undefined){r=true}if(r&&(!m||h.disabled||s=="reset"||s=="button"||(s=="checkbox"||s=="radio")&&!h.checked||(s=="submit"||s=="image")&&h.form&&h.form.clk!=h||u=="select"&&h.selectedIndex==-1)){return null}if(u=="select"){var k=h.selectedIndex;if(k<0){return null}var g=[],q=h.options;var o=(s=="select-one");var l=(o?k+1:q.length);for(var j=(o?k:0);j<l;j++){var p=q[j];if(p.selected){var w=p.value;if(!w){w=(p.attributes&&p.attributes.value&&!(p.attributes.value.specified))?p.text:p.value}if(o){return w}g.push(w)}}return g}return a(h).val()};a.fn.clearForm=function(g){return this.each(function(){a("input,select,textarea",this).clearFields(g)})};a.fn.clearFields=a.fn.clearInputs=function(g){var h=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var i=this.type,j=this.tagName.toLowerCase();if(h.test(i)||j=="textarea"){this.value=""}else{if(i=="checkbox"||i=="radio"){this.checked=false}else{if(j=="select"){this.selectedIndex=-1}else{if(i=="file"){if(/MSIE/.test(navigator.userAgent)){a(this).replaceWith(a(this).clone(true))}else{a(this).val("")}}else{if(g){if((g===true&&/hidden/.test(i))||(typeof g=="string"&&a(this).is(g))){this.value=""}}}}}}})};a.fn.resetForm=function(){return this.each(function(){if(typeof this.reset=="function"||(typeof this.reset=="object"&&!this.reset.nodeType)){this.reset()}})};a.fn.enable=function(g){if(g===undefined){g=true}return this.each(function(){this.disabled=!g})};a.fn.selected=function(g){if(g===undefined){g=true}return this.each(function(){var i=this.type;if(i=="checkbox"||i=="radio"){this.checked=g}else{if(this.tagName.toLowerCase()=="option"){var h=a(this).parent("select");if(g&&h[0]&&h[0].type=="select-one"){h.find("option").selected(false)}this.selected=g}}})};a.fn.ajaxSubmit.debug=false;function f(){if(!a.fn.ajaxSubmit.debug){return}var g="[jquery.form] "+Array.prototype.join.call(arguments,"");if(window.console&&window.console.log){window.console.log(g)}else{if(window.opera&&window.opera.postError){window.opera.postError(g)}}}})((typeof(jQuery)!="undefined")?jQuery:window.Zepto);