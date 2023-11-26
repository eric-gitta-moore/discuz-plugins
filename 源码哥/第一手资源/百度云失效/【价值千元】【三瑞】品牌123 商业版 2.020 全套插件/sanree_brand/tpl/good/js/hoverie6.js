stuHoverbrand = function() {
var cssRule;
var newSelector;
for (var i = 0; i < document.styleSheets.length; i++)
   for (var x = 0; x < document.styleSheets[i].rules.length ; x++)
    {
    cssRule = document.styleSheets[i].rules[x];
    if (cssRule.selectorText.indexOf("LI:hover") != -1)
    {
     newSelector = cssRule.selectorText.replace(/LI:hover/gi, "LI.iehover");
     document.styleSheets[i].addRule(newSelector , cssRule.style.cssText);
    }
   }
var obj=document.getElementById("onedata");
var getElm = obj.getElementsByTagName("LI");
for (var i=0; i<getElm.length; i++) {
   getElm[i].onmouseover=function() {
    this.className+=" iehover";
   }
   getElm[i].onmouseout=function() {
    this.className=this.className.replace(new RegExp(" iehover\\b"), "");
   }
}
}
if (window.attachEvent) window.attachEvent("onload", stuHoverbrand);
var isIE=!!window.ActiveXObject; 
var isIE6=isIE&&!window.XMLHttpRequest; 
if (window.attachEvent&&isIE6) window.attachEvent("onload", stuHoverbrand);