function GetFill(value)
{
	if(value < neutralVal[0]){
		return valColors[0];
	}
	if(value > neutralVal[1]){
		return valColors[2];
	}
	return valColors[1];
}

function chart(parent)
{

if(bars)
{

var i=val[0];
var k=0;
var ok=0;

for(var j=1;j<bars;j++)
{

if(i<val[j])
{
i=val[j];
}

}

s=s*6+21;

if(!i)
{
i=1;
}

while(i<14)
{
i*=10;
ok++;
}

while(i>999)
{
i=Math.floor(i/10);
k++;
}

if(i>150)
{
i=Math.floor(i/10);
k++;
}

i-=i%15;

while(k)
{
i*=10;
k--;
}

while(ok)
{
i/=10;
ok--;
}
i/=3;


}
var chart = document.getElementById(parent);
var width=s*bars+10-bars%10;


var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
svg.setAttributeNS(null, 'height', '300');
svg.setAttributeNS(null,'width', 90+width);
svg.setAttributeNS(null, 'viewBox', '0 0 '+ (90+width) +' 300');
svg.setAttributeNS(null,'style', 'overflow: hidden;');
svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");
chart.appendChild(svg);

var svgNS = svg.namespaceURI;

var group = document.createElementNS(svgNS, 'g');
svg.appendChild(group);

var rect = document.createElementNS(svgNS, 'rect');
rect.setAttributeNS(null, 'height','1');
rect.setAttributeNS(null, 'width', width);
rect.setAttributeNS(null, 'x', '45');
rect.setAttributeNS(null, 'y','242');
rect.setAttributeNS(null, 'stroke','none');
rect.setAttributeNS(null, 'stroke-width','0');
rect.setAttributeNS(null, 'fill','#333333');
group.appendChild(rect);

var rect = document.createElementNS(svgNS, 'rect');
rect.setAttributeNS(null, 'height','184');
rect.setAttributeNS(null, 'width','1');
rect.setAttributeNS(null, 'x', '45');
rect.setAttributeNS(null, 'y','58');
rect.setAttributeNS(null, 'stroke','none');
rect.setAttributeNS(null, 'stroke-width','0');
rect.setAttributeNS(null, 'fill','#333333');
group.appendChild(rect);


for(var j=0;j<4;j++)
{
var rect = document.createElementNS(svgNS, 'rect');
rect.setAttributeNS(null, 'height','1');
rect.setAttributeNS(null, 'width', width);
rect.setAttributeNS(null, 'x', '46');
rect.setAttributeNS(null, 'y',196-j*46);
rect.setAttributeNS(null, 'stroke','none');
rect.setAttributeNS(null, 'stroke-width','0');
rect.setAttributeNS(null, 'fill','#cccccc');
group.appendChild(rect);
}


var group = document.createElementNS(svgNS, 'g');
svg.appendChild(group);

for(var j=0;j<bars;j++)
{
var text = document.createElementNS(svgNS, 'text');
text.setAttributeNS(null, 'text-anchor','middle');
text.setAttributeNS(null, 'y','259');
text.setAttributeNS(null, 'font-family','Arial');
text.setAttributeNS(null, 'font-size','11');
text.setAttributeNS(null, 'stroke','none');
text.setAttributeNS(null, 'stroke-width','0');
text.setAttributeNS(null, 'fill','#222222');

if(category[j].words.length > 1){
for(var k=0; k<category[j].words.length; k++){
var tspan = document.createElementNS(svgNS, 'tspan');
tspan.setAttributeNS(null, 'x', 55+(s-21)/2+s*j);
tspan.setAttributeNS(null, 'dy', 10*k);
var txt = document.createTextNode(category[j].words[k]);
tspan.appendChild(txt);
text.appendChild(tspan);
}
}
else{
text.setAttributeNS(null, 'x', 55+(s-21)/2+s*j);
var txt = document.createTextNode(category[j].words[0]);
text.appendChild(txt);
}
group.appendChild(text);


}

var group = document.createElementNS(svgNS, 'g');
svg.appendChild(group);
for(var j=0;j<5;j++)
{
var text = document.createElementNS(svgNS, 'text');
text.setAttributeNS(null, 'text-anchor','end');
text.setAttributeNS(null, 'x', '36');
text.setAttributeNS(null, 'y', 246-j*46);
text.setAttributeNS(null, 'font-family','Arial');
text.setAttributeNS(null, 'font-size','11');
text.setAttributeNS(null, 'stroke','none');
text.setAttributeNS(null, 'stroke-width','0');
text.setAttributeNS(null, 'fill','#444444');
var txt = document.createTextNode(Math.floor( j*i*10 ) /10);
text.appendChild(txt);
group.appendChild(text);
}


var group = document.createElementNS(svgNS, 'g');
svg.appendChild(group);

for(var j=0;j<bars;j++)
{
var perc = (val[j]/i)*25;
var height = Math.floor(184*perc/100)
var start = 242-height;

if(perc<2)
{
start-=2;
height+=2;
}

var rect = document.createElementNS(svgNS, 'rect');
var fill = '#c124dc';
if(useCatColors && useValColors){
console.log('error');
}
else{
fill = useCatColors ? catColors[j] : GetFill(val[j]);
}
rect.setAttributeNS(null, 'height', height);
rect.setAttributeNS(null, 'width', s-20);
rect.setAttributeNS(null, 'x', 55+s*j);
rect.setAttributeNS(null, 'y', start);
rect.setAttributeNS(null, 'stroke','none');
rect.setAttributeNS(null, 'stroke-width','0');
rect.setAttributeNS(null, 'fill', fill);
group.appendChild(rect);

var txtgroup = document.createElementNS(svgNS, 'g');
txtgroup.setAttributeNS(null, 'class','tooltip');
group.appendChild(txtgroup);

var text = document.createElementNS(svgNS, 'text');
text.setAttributeNS(null, 'text-anchor','middle');
text.setAttributeNS(null, 'x', 55+(s-21)/2 +s*j);
text.setAttributeNS(null, 'y', start-4);
text.setAttributeNS(null, 'stroke-width','2');
text.setAttributeNS(null, 'fill', fill);
var txt = document.createTextNode(val[j]);
text.appendChild(txt);
txtgroup.appendChild(text);
}

}