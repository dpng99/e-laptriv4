var Ve=Object.defineProperty;var Ue=(s,t,e)=>t in s?Ve(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e;var ie=(s,t,e)=>Ue(s,typeof t!="symbol"?t+"":t,e);import{r as c,c as N,j as z,u as ce,K as re,M as se}from"./app-CvNLW4P0.js";import{a as pe,u as Ae,s as oe,g as Fe,b as Ye}from"./Paper-Cl672vd7.js";import{b as ze,c as fe,d as je,e as Oe,u as L,a as ae}from"./useTimeout-B0m-c2qx.js";function le(s){try{return s.matches(":focus-visible")}catch{}return!1}function We(s){const{focusableWhenDisabled:t,disabled:e,composite:o=!1,tabIndex:i=0,isNativeButton:r}=s,u=o&&t!==!1,a=o&&t===!1;return c.useMemo(()=>{const f={onKeyDown(R){e&&t&&R.key!=="Tab"&&R.preventDefault()}};return o||(f.tabIndex=i,!r&&e&&(f.tabIndex=t?i:-1)),(r&&(t||u)||!r&&e)&&(f["aria-disabled"]=e),r&&(!t||a)&&(f.disabled=e),f},[o,e,t,u,a,r,i])}const Xe={};function He(s){const{nativeButton:t,disabled:e,type:o,hasFormAction:i=!1,tabIndex:r=0,focusableWhenDisabled:u,stopEventPropagation:a=!1,onBeforeKeyDown:m,onBeforeKeyUp:f}=s,R=c.useRef(null),p=u===!0,y=We({focusableWhenDisabled:p,disabled:e,isNativeButton:t,tabIndex:r}),T=c.useCallback(()=>{const d=R.current;return d==null?t:d.tagName==="BUTTON"?!0:!!(d.tagName==="A"&&d.href)},[t]),P=c.useMemo(()=>{const d=p?{}:{tabIndex:e?-1:r};return t?(d.type=o===void 0&&!i?"button":o,p||(d.disabled=e)):(d.role="button",!p&&e&&(d["aria-disabled"]=e)),p?{...d,...y}:d},[e,p,y,i,t,r,o]);return{getButtonProps:c.useCallback((d=Xe)=>{const{onClick:K,onKeyDown:g,onKeyUp:C,...j}=d;return{...P,...j,onClick:l=>{if(a&&l.stopPropagation(),e){l.preventDefault();return}K==null||K(l)},onKeyDown:l=>{if(p&&y.onKeyDown(l),!e&&(m==null||m(l),g==null||g(l),!(l.target!==l.currentTarget||T()))){if(l.key===" "){l.preventDefault();return}l.key==="Enter"&&(l.preventDefault(),l.currentTarget.click())}},onKeyUp:l=>{e||(f==null||f(l),C==null||C(l),l.target===l.currentTarget&&!T()&&l.key===" "&&!l.defaultPrevented&&l.currentTarget.click())}}},[P,e,p,y,T,m,f,a]),rootRef:R}}class G{constructor(){ie(this,"mountEffect",()=>{this.shouldMount&&!this.didMount&&this.ref.current!==null&&(this.didMount=!0,this.mounted.resolve())});this.ref={current:null},this.mounted=null,this.didMount=!1,this.shouldMount=!1,this.setShouldMount=null}static create(){return new G}static use(){const t=ze(G.create).current,[e,o]=c.useState(!1);return t.shouldMount=e,t.setShouldMount=o,c.useEffect(t.mountEffect,[e]),t}mount(){return this.mounted||(this.mounted=Je(),this.shouldMount=!0,this.setShouldMount(this.shouldMount)),this.mounted}start(...t){this.mount().then(()=>{var e;return(e=this.ref.current)==null?void 0:e.start(...t)})}stop(...t){this.mount().then(()=>{var e;return(e=this.ref.current)==null?void 0:e.stop(...t)})}pulsate(...t){this.mount().then(()=>{var e;return(e=this.ref.current)==null?void 0:e.pulsate(...t)})}}function qe(){return G.use()}function Je(){let s,t;const e=new Promise((o,i)=>{s=o,t=i});return e.resolve=s,e.reject=t,e}function _e(s){const{className:t,classes:e,pulsate:o=!1,rippleX:i,rippleY:r,rippleSize:u,in:a,onExited:m,timeout:f}=s,[R,p]=c.useState(!1),y=fe(),T=c.useRef(!1),P=c.useRef(m);P.current=m;const w=m!=null,d=N(t,e.ripple,e.rippleVisible,o&&e.ripplePulsate),K={width:u,height:u,top:-(u/2)+r,left:-(u/2)+i},g=N(e.child,R&&e.childLeaving,o&&e.childPulsate);return!a&&!R&&p(!0),c.useEffect(()=>{!a&&w?T.current||(T.current=!0,y.start(f,()=>{var C;T.current=!1,(C=P.current)==null||C.call(P)})):(T.current=!1,y.clear())},[y,w,a,f]),z.jsx("span",{className:d,style:K,children:z.jsx("span",{className:g})})}const x=pe("MuiTouchRipple",["root","ripple","rippleVisible","ripplePulsate","child","childLeaving","childPulsate"]),te=550,Ge=80,_={},ue=[],Qe=()=>{};function ee(s,t){const e=new Set(t),o=new Map;let i=[];for(const u of s)e.has(u)?i.length>0&&(o.set(u,i),i=[]):i.push(u);const r=[];for(const u of t){const a=o.get(u);a&&r.push(...a),r.push(u)}return r.push(...i),r}function Ze({event:s,element:t,center:e}){const o=t?t.getBoundingClientRect():{width:0,height:0,left:0,top:0};let i,r;if(e||s===void 0||s.clientX===0&&s.clientY===0||!s.clientX&&!s.touches)i=Math.round(o.width/2),r=Math.round(o.height/2);else{const{clientX:a,clientY:m}=s.touches&&s.touches.length>0?s.touches[0]:s;i=Math.round(a-o.left),r=Math.round(m-o.top)}let u;if(e)u=Math.sqrt((2*o.width**2+o.height**2)/3),u%2===0&&(u+=1);else{const a=Math.max(Math.abs((t?t.clientWidth:0)-i),i)*2+2,m=Math.max(Math.abs((t?t.clientHeight:0)-r),r)*2+2;u=Math.sqrt(a**2+m**2)}return{rippleX:i,rippleY:r,rippleSize:u}}const ve=se`
  0% {
    transform: scale(0);
    opacity: 0.1;
  }

  100% {
    transform: scale(1);
    opacity: 0.3;
  }
`,et=se`
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
  }
`,tt=se`
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(0.92);
  }

  100% {
    transform: scale(1);
  }
`;function st(s){if(s.motion.reducedMotion==="always")return null;const t=re`
    &.${x.rippleVisible} {
      animation-name: ${ve};
      animation-duration: ${te}ms;
      animation-timing-function: ${s.transitions.easing.easeInOut};
    }

    &.${x.ripplePulsate} {
      animation-duration: ${s.transitions.duration.shorter}ms;
    }

    & .${x.childLeaving} {
      animation-name: ${et};
      animation-duration: ${te}ms;
      animation-timing-function: ${s.transitions.easing.easeInOut};
    }

    & .${x.childPulsate} {
      animation-name: ${tt};
      animation-duration: 2500ms;
      animation-timing-function: ${s.transitions.easing.easeInOut};
      animation-iteration-count: infinite;
      animation-delay: 200ms;
    }
  `;return s.motion.reducedMotion==="system"?re`
      @media (prefers-reduced-motion: no-preference) {
        ${t}
      }
    `:t}const ot=oe("span",{name:"MuiTouchRipple",slot:"Root"})({overflow:"hidden",pointerEvents:"none",position:"absolute",zIndex:0,top:0,right:0,bottom:0,left:0,borderRadius:"inherit"}),nt=oe(_e,{name:"MuiTouchRipple",slot:"Ripple"})`
  opacity: 0;
  position: absolute;

  &.${x.rippleVisible} {
    opacity: 0.3;
    transform: scale(1);
  }

  /*
   * Order matters: 'child', 'childLeaving' and 'childPulsate' apply to the same
   * element with equal specificity, so the later rule wins. 'child' must come
   * before 'childLeaving' so the leaving 'opacity: 0' takes precedence. A focus
   * (pulsate) ripple keeps 'pulsateKeyframe' (no opacity animation) on exit, so
   * it relies on this static 'opacity: 0' to disappear on blur instead of
   * lingering until removal.
   */
  & .${x.child} {
    opacity: 1;
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: currentColor;
  }

  & .${x.childLeaving} {
    opacity: 0;
  }

  & .${x.childPulsate} {
    position: absolute;
    /* @noflip */
    left: 0px;
    top: 0;
  }

  ${({theme:s})=>st(s)}
`,it=c.forwardRef(function(t,e){const o=ce({props:t,name:"MuiTouchRipple"}),i=Ae(),r=je(i.motion.reducedMotion,!1),{center:u=!1,classes:a=_,className:m,...f}=o,[R,p]=c.useState({items:ue,order:ue}),y=R.items,T=c.useRef(0),P=c.useRef(null),w=c.useRef(!1);Oe(()=>(w.current=!0,()=>{w.current=!1})),c.useEffect(()=>{P.current&&(P.current(),P.current=null)},[y]);const d=c.useRef(!1),K=fe(),g=c.useRef(null),C=c.useRef(null),j=L(n=>{w.current&&p(k=>{const B=k.items.filter(b=>b.key!==n),D=ee(k.order.filter(b=>b!==n),B.filter(b=>!b.exiting).map(b=>b.key));return{items:B,order:D}})}),O=L(n=>{const{pulsate:k,rippleX:B,rippleY:D,rippleSize:b,cb:E}=n,$=T.current;T.current+=1,p(V=>{const U=[...V.items,{key:$,pulsate:k,rippleX:B,rippleY:D,rippleSize:b,exiting:!1}];return{items:U,order:ee(V.order,U.filter(S=>!S.exiting).map(S=>S.key))}}),P.current=E}),F=L((n=_,k=_,B=Qe)=>{const{pulsate:D=!1,center:b=u||k.pulsate,fakeElement:E=!1}=k;if((n==null?void 0:n.type)==="mousedown"&&d.current){d.current=!1;return}(n==null?void 0:n.type)==="touchstart"&&(d.current=!0);const $=E?null:C.current,{rippleX:V,rippleY:U,rippleSize:S}=Ze({event:n,element:$,center:b});n!=null&&n.touches?g.current===null&&(g.current=()=>{O({pulsate:D,rippleX:V,rippleY:U,rippleSize:S,cb:B})},K.start(Ge,()=>{g.current&&(g.current(),g.current=null)})):O({pulsate:D,rippleX:V,rippleY:U,rippleSize:S,cb:B})}),Y=L(()=>{F(_,{pulsate:!0})}),l=L((n,k)=>{if(K.clear(),(n==null?void 0:n.type)==="touchend"&&g.current){g.current(),g.current=null,K.start(0,()=>{l(n,k)});return}g.current=null,p(B=>{const D=B.items.findIndex(E=>!E.exiting);if(D===-1)return B;const b=B.items.slice();return b[D]={...b[D],exiting:!0},{items:b,order:ee(B.order,b.filter(E=>!E.exiting).map(E=>E.key))}}),P.current=k});c.useImperativeHandle(e,()=>({pulsate:Y,start:F,stop:l}),[Y,F,l]);const Q=new Map(y.map(n=>[n.key,n])),Z=R.order.map(n=>Q.get(n)).filter(Boolean);return z.jsx(ot,{className:N(x.root,a.root,m),ref:C,...f,children:Z.map(n=>z.jsx(nt,{classes:{ripple:N(a.ripple,x.ripple),rippleVisible:N(a.rippleVisible,x.rippleVisible),ripplePulsate:N(a.ripplePulsate,x.ripplePulsate),child:N(a.child,x.child),childLeaving:N(a.childLeaving,x.childLeaving),childPulsate:N(a.childPulsate,x.childPulsate)},timeout:r.shouldReduceMotion?0:te,pulsate:n.pulsate,rippleX:n.rippleX,rippleY:n.rippleY,rippleSize:n.rippleSize,in:!n.exiting,onExited:()=>j(n.key)},n.key))})});function rt(s){return Fe("MuiButtonBase",s)}const at=pe("MuiButtonBase",["root","disabled","focusVisible"]),lt=s=>{const{disabled:t,focusVisible:e,focusVisibleClassName:o,suppressFocusVisible:i,classes:r}=s,a=Ye({root:["root",t&&"disabled",e&&!i&&"focusVisible"]},rt,r);return e&&!i&&o&&(a.root+=` ${o}`),a},ut=oe("button",{name:"MuiButtonBase",slot:"Root"})({display:"inline-flex",alignItems:"center",justifyContent:"center",position:"relative",boxSizing:"border-box",WebkitTapHighlightColor:"transparent",backgroundColor:"transparent",outline:0,border:0,margin:0,borderRadius:0,padding:0,cursor:"pointer",userSelect:"none",verticalAlign:"middle",MozAppearance:"none",WebkitAppearance:"none",textDecoration:"none",color:"inherit","&::-moz-focus-inner":{borderStyle:"none"},[`&.${at.disabled}`]:{pointerEvents:"none",cursor:"default"},"@media print":{colorAdjust:"exact"}}),mt=c.forwardRef(function(t,e){const o=ce({props:t,name:"MuiButtonBase"}),{action:i,centerRipple:r=!1,children:u,className:a,component:m="button",disabled:f=!1,disableRipple:R=!1,disableTouchRipple:p=!1,focusRipple:y=!1,focusVisibleClassName:T,focusableWhenDisabled:P,suppressFocusVisible:w=!1,internalNativeButton:d,LinkComponent:K="a",nativeButton:g,onBlur:C,onClick:j,onContextMenu:O,onDragLeave:F,onFocus:Y,onFocusVisible:l,onKeyDown:Q,onKeyUp:Z,onMouseDown:n,onMouseLeave:k,onMouseUp:B,onTouchEnd:D,onTouchMove:b,onTouchStart:E,tabIndex:$=0,TouchRippleProps:V,touchRippleRef:U,type:S,...H}=o,v=!!(H.href||H.to),de=!!H.formAction;let W=m;W==="button"&&v&&(W=K);const he=g??(typeof W=="string"?W==="button":d??!1),M=qe(),me=ae(M.ref,U),[A,q]=c.useState(!1);(f||w)&&A&&q(!1);const be=L(h=>{y&&!h.repeat&&A&&h.key===" "&&M.stop(h,()=>{M.start(h)})}),ye=L(h=>{y&&h.key===" "&&A&&!h.defaultPrevented&&M.stop(h,()=>{M.pulsate(h)})}),{getButtonProps:ge,rootRef:X}=He({nativeButton:he,disabled:f,type:S,hasFormAction:de,tabIndex:$,onBeforeKeyDown:be,onBeforeKeyUp:ye}),{onClick:Me,onKeyDown:Re,onKeyUp:xe,...Pe}=ge({onClick:j,onKeyDown:Q,onKeyUp:Z});c.useImperativeHandle(i,()=>({focusVisible:()=>{q(!0),X.current.focus()}}),[X]);const Be=M.shouldMount&&!R&&!f;c.useEffect(()=>{A&&y&&!R&&M.pulsate()},[R,y,A,M]);const ke=I(M,"start",n,p),Te=I(M,"stop",O,p),Ce=I(M,"stop",F,p),De=I(M,"stop",B,p),we=I(M,"stop",h=>{A&&h.preventDefault(),k&&k(h)},p),Ke=I(M,"start",E,p),Ee=I(M,"stop",D,p),Ne=I(M,"stop",b,p),Se=I(M,"stop",h=>{le(h.target)||q(!1),C&&C(h)},!1),Ie=L(h=>{X.current||(X.current=h.currentTarget),!w&&le(h.target)&&(q(!0),l&&l(h)),Y&&Y(h)}),J={};v&&(J.tabIndex=f?-1:$,f&&(J["aria-disabled"]=f),J.type=S);const Le=ae(e,X),ne={...o,centerRipple:r,component:m,disabled:f,disableRipple:R,disableTouchRipple:p,focusRipple:y,suppressFocusVisible:w,tabIndex:$,focusVisible:A},$e=lt(ne);return z.jsxs(ut,{as:W,className:N($e.root,a),ownerState:ne,onBlur:Se,onClick:Me,onContextMenu:Te,onFocus:Ie,onKeyDown:Re,onKeyUp:xe,onMouseDown:ke,onMouseLeave:we,onMouseUp:De,onDragLeave:Ce,onTouchEnd:Ee,onTouchMove:Ne,onTouchStart:Ke,ref:Le,...v?J:Pe,...H,children:[u,Be?z.jsx(it,{ref:me,center:r,...V}):null]})});function I(s,t,e,o=!1){return L(i=>(e&&e(i),o||s[t](i),!0))}export{mt as B,le as i};
