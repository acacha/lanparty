/**
 * Copyright 2016 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

// DO NOT EDIT THIS GENERATED OUTPUT DIRECTLY!
// This file should be overwritten as part of your build process.
// If you need to extend the behavior of the generated service worker, the best approach is to write
// additional code and include it using the importScripts option:
//   https://github.com/GoogleChrome/sw-precache#importscripts-arraystring
//
// Alternatively, it's possible to make changes to the underlying template file and then use that as the
// new base for generating output, via the templateFilePath option:
//   https://github.com/GoogleChrome/sw-precache#templatefilepath-string
//
// If you go that route, make sure that whenever you update your sw-precache dependency, you reconcile any
// changes made to this original template file with your modified copy.

// This generated service worker JavaScript will precache your site's resources.
// The code needs to be saved in a .js file at the top-level of your site, and registered
// from your pages in order to be used. See
// https://github.com/googlechrome/sw-precache/blob/master/demo/app/js/service-worker-registration.js
// for an example of how you can register this script and handle various service worker events.

/* eslint-env worker, serviceworker */
/* eslint-disable indent, no-unused-vars, no-multiple-empty-lines, max-nested-callbacks, space-before-function-paren, quotes, comma-spacing */
'use strict';

var precacheConfig = [["/","bae0ac6f565657b4cf9fe8d715e1c7b1"],["/home","fdea42ff49a556128a2c7a5d771bc8d3"],["css/app.css","d9f389693f5cc51d0c97f25afc485077"],["css/odometer-theme-digital.css","c7118c66e3f5a7ca1a87d291d102cd16"],["favicon.ico","d41d8cd98f00b204e9800998ecf8427e"],["fonts/fr-bold.woff","c55ff0a4b73fd394622c34af1bbb2d1e"],["fonts/fr-title.woff","411ef14d6d42b776be008b68154994df"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.eot","a7b95dbdd87e0c809570affaf366a434"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.svg","5bf145531213545e03ff41cd27df7d2b"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.ttf","98b6db59be947f563350d2284fc9ea36"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.woff","2ef8ba3410dcc71578a880e7064acd7a"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.woff2","5e2f92123d241cabecf0b289b9b08d4a"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.eot","dcce4b7fbd5e895561e18af4668265af"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.svg","5eb754ab7dbd2fee562360528db4c3c0"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.ttf","65b9977aa23185e8964b36eddbce7a20"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.woff","427d721b86fc9c68b2e85ad42b69238c"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.woff2","e6257a726a0cf6ec8c6fec22821c055f"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.eot","46e7cec623d8bd790d9fdbc8de2d3ee7"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.svg","49279363201ed19a840796e05a74a91b"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.ttf","ff8d9f8adb0d09f11d4816a152672f53"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff","a7140145ebaaf5fb14e40430af5d25c4"],["fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff2","418dad87601f9c8abd0e5798c0dc1feb"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.eot","f4769f9bdb7466be65088239c12046d1"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.svg","89889688147bd7575d6327160d64e760"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.ttf","e18bbf611f2a2e43afc071aa2f4e1512"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.woff","fa2772327f55d8198301fdb8bcfc8158"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.woff2","448c34a56d699c29117adc64c43affeb"],["fonts/vendor/font-awesome/fontawesome-webfont.eot","674f50d287a8c48dc19ba404d20fe713"],["fonts/vendor/font-awesome/fontawesome-webfont.svg","912ec66d7572ff821749319396470bde"],["fonts/vendor/font-awesome/fontawesome-webfont.ttf","b06871f281fee6b241d60582ae9369b9"],["fonts/vendor/font-awesome/fontawesome-webfont.woff","fee66e712a8a08eef5805a46892932ad"],["fonts/vendor/font-awesome/fontawesome-webfont.woff2","af7ae505a9eed503f8b8e6982036873e"],["fonts/vendor/material-design-icons-icondist/MaterialIcons-Regular.eot","b661c28b0f28606a96722ad2d9588b70"],["fonts/vendor/material-design-icons-icondist/MaterialIcons-Regular.ttf","586090b38a233ce0201fb221eb117a36"],["fonts/vendor/material-design-icons-icondist/MaterialIcons-Regular.woff","9219a80f0478e0bfdee5f4c753ce8535"],["fonts/vendor/material-design-icons-icondist/MaterialIcons-Regular.woff2","bca3a1873ac988faff0817eca96b2d86"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-100.woff","c8fb2f714bbc7bc3e8dfffa916b286dc"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-100.woff2","4124805c0503dbfe42dd67d7f5715964"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-100italic.woff","d1f3f2d02ee4d7d2d4b1ad865014f189"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-100italic.woff2","e4bf47bd171a9b2a72dd84c58bf90edf"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-200.woff","edbce16a90aa22c297a0307b85789837"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-200.woff2","444ae007121264bc1969d49b4031f9b2"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-200italic.woff","d7bbb730d9b5e11720b3eb32326dcca7"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-200italic.woff2","f316c5d1ec40f3e68654c3f38b3999f3"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-300.woff","5e86df2cad22d2ef2b03516334afae5e"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-300.woff2","0a7c6df06e85d978d096d4d18fd8d43d"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-300italic.woff","37c74a8d2d0d36a0a2c6e9a37ee15b0c"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-300italic.woff2","c076c4892bc7a4be7b9097e97a35012d"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-400.woff","f29d2b8559699b6beb5b29b25b8bc572"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-400.woff2","501ce09c42716a2f6e1503a25eb174c9"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-400italic.woff","22e7b04e5f2a901d49d4d342315a715a"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-400italic.woff2","882908d9950d9c86ebd380877f293d95"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-500.woff","991b453bf90a0980e78966d2af7e3d3a"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-500.woff2","f0f2716c5fe401d175b88715e7d28685"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-500italic.woff","f3d41e4cdcc2314e49ddcea751d6f87f"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-500italic.woff2","4590ebba421b3288c305305d7fa7b504"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-600.woff","f6dc6096f48956908c1787d9a722570a"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-600.woff2","15c24f7109941777774ddd2c636c6a50"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-600italic.woff","02c4833312d94b1b0866f073023a250e"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-600italic.woff2","6d10b80529d5c36c7c09fca7193af0fc"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-700.woff","957e93fbbe131a59791cd820d98b7109"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-700.woff2","79982cd1f74c6fa7451bf9b37ead09ff"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-700italic.woff","ca627c5ccc65cf80c2ecaea44b997de9"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-700italic.woff2","283438e9577fe6a684466bb100e105ec"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-800.woff","756655905d91b77960888262e7d58d35"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-800.woff2","35386154b78d046218fc8f88a44ff515"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-800italic.woff","a69f0add9d86c1a84311d7dd8693ba4a"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-800italic.woff2","e1b52a7bd83e2324db6d92bdc206844c"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-900.woff","186cae8091da578150d81958e217714a"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-900.woff2","260c2ea3ef57feb82251952e605a36d5"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-900italic.woff","43b527fe77254f97ea36e2b54e845ec4"],["fonts/vendor/typeface-montserrat/files/montserrat-latin-900italic.woff2","d785fb9fc74588ffb7f306799709a97d"],["fonts/vendor/typeface-roboto/files/roboto-latin-100.woff","e9dbbe8a693dd275c16d32feb101f1c1"],["fonts/vendor/typeface-roboto/files/roboto-latin-100.woff2","987b84570ea69ee660455b8d5e91f5f1"],["fonts/vendor/typeface-roboto/files/roboto-latin-100italic.woff","d704bb3d579b7d5e40880c75705c8a71"],["fonts/vendor/typeface-roboto/files/roboto-latin-100italic.woff2","6232f43d15b0e7a0bf0fe82e295bdd06"],["fonts/vendor/typeface-roboto/files/roboto-latin-300.woff","a1471d1d6431c893582a5f6a250db3f9"],["fonts/vendor/typeface-roboto/files/roboto-latin-300.woff2","55536c8e9e9a532651e3cf374f290ea3"],["fonts/vendor/typeface-roboto/files/roboto-latin-300italic.woff","210a7c781f5a354a0e4985656ab456d9"],["fonts/vendor/typeface-roboto/files/roboto-latin-300italic.woff2","d69924b98acd849cdeba9fbff3f88ea6"],["fonts/vendor/typeface-roboto/files/roboto-latin-400.woff","bafb105baeb22d965c70fe52ba6b49d9"],["fonts/vendor/typeface-roboto/files/roboto-latin-400.woff2","5d4aeb4e5f5ef754e307d7ffaef688bd"],["fonts/vendor/typeface-roboto/files/roboto-latin-400italic.woff","9680d5a0c32d2fd084e07bbc4c8b2923"],["fonts/vendor/typeface-roboto/files/roboto-latin-400italic.woff2","d8bcbe724fd6f4ba44d0ee6a2675890f"],["fonts/vendor/typeface-roboto/files/roboto-latin-500.woff","de8b7431b74642e830af4d4f4b513ec9"],["fonts/vendor/typeface-roboto/files/roboto-latin-500.woff2","285467176f7fe6bb6a9c6873b3dad2cc"],["fonts/vendor/typeface-roboto/files/roboto-latin-500italic.woff","ffcc050b2d92d4b14a4fcb527ee0bcc8"],["fonts/vendor/typeface-roboto/files/roboto-latin-500italic.woff2","510dec37fa69fba39593e01a469ee018"],["fonts/vendor/typeface-roboto/files/roboto-latin-700.woff","cf6613d1adf490972c557a8e318e0868"],["fonts/vendor/typeface-roboto/files/roboto-latin-700.woff2","037d830416495def72b7881024c14b7b"],["fonts/vendor/typeface-roboto/files/roboto-latin-700italic.woff","846d1890aee87fde5d8ced8eba360c3a"],["fonts/vendor/typeface-roboto/files/roboto-latin-700italic.woff2","010c1aeee3c6d1cbb1d5761d80353823"],["fonts/vendor/typeface-roboto/files/roboto-latin-900.woff","8c2ade503b34e31430d6c98aa29a52a3"],["fonts/vendor/typeface-roboto/files/roboto-latin-900.woff2","19b7a0adfdd4f808b53af7e2ce2ad4e5"],["fonts/vendor/typeface-roboto/files/roboto-latin-900italic.woff","bc833e725c137257c2c42a789845d82f"],["fonts/vendor/typeface-roboto/files/roboto-latin-900italic.woff2","7b770d6c53423deb1a8e49d3c9175184"],["img/404.jpg","e82153cdee24c0f31c86b0d5b8937c8b"],["img/AgeOfEmpires2.png","490a281628fe571b231ab6d74e740e7e"],["img/CaptureTheFlag.jpeg","724a8b076433a8caec0301914d7cb698"],["img/Cartell2019a.jpg","2c8dcce77ead78765edb4625d5cf40bb"],["img/Cartell2019b.jpg","40ede4f5776eca7b817827c421c4edbc"],["img/CounterStrike.jpeg","70303b8c8afbb38982c81278e6c8340d"],["img/CounterStrike.png","18ebe1833089f7fd6e34478d313f46b0"],["img/FIFA18.png","ecf523aa11770d2a69225eb32f9ab61a"],["img/Fifa18.jpeg","5b46f3ecab1a07f58052050a20dd928b"],["img/Fifa19.jpg","25ca4546a0ef8185454b21ab57e11b22"],["img/Lanparty.jpg","4af97fd59b78093859a20fd739537cdc"],["img/Lanparty3.jpg","786bd0992ce2859e6c2e459df0c9df86"],["img/Lanparty4.jpg","0e3b2a5bf6792ce3345b40e9f1b789dd"],["img/LanpartyLanding.jpg","db2d83476e5ccf82d2fa48e225b3154c"],["img/LanpartyLanding2.jpg","5cf0c5d0d04dcc691f7d291efa57734c"],["img/LanpartyLanding2019.jpg","0a225d1d3fbcaca5e9b7f9a4125831d4"],["img/LeagueofLegends.png","6ca8a97ae855a25e8abf4d67f88a8754"],["img/LoL.jpeg","24647659d4920584b96a358f9cc4313a"],["img/LoL.png","8729b68babaa2b8dd72d6cc5bdf59c9a"],["img/Overwatch.jpeg","1811cfcd68ba3ca1260e0b8054a40b3e"],["img/cartell LAN Party 2017 2.jpg","2f04bb380a89e2546b43c7affaffa5e0"],["img/cartellLANParty2017.jpg","2f04bb380a89e2546b43c7affaffa5e0"],["img/cartellLandingPage.jpg","96db8d9b816abcb064ddfd20d01299fb"],["img/code.jpeg","81468ec538b5d93ce1a5bd16f6ba3571"],["img/futurama.jpg","e380477042fd66c022e93ef471397e22"],["img/green.png","ae7f07a1359f4a2919e447bca6f3dfb4"],["img/group1.jpg","64e8d8acf6c892c4a1b071aeff6ea1d3"],["img/group2.jpg","a19f7f04eeb50add76b9d4cc6f4b34eb"],["img/group3.jpg","066de0298c4f5871cd7c5fd7c30fd549"],["img/group4.jpg","7127b06dbc9c0dc9655c14888e5f5da6"],["img/group5.jpg","97d11b05467753f7568d9bf8d6bb3233"],["img/groupPlaceholder.jpg","cc107bc4a8a640d4cb48d639b11e1709"],["img/hardware.jpg","967d6848fd0ae289b3103edb81f5dc59"],["img/hero.jpeg","ffec432016d09b9ac44d9bd71e620611"],["img/icons/icon-128x128.png","075f048017ddfb53b15aa1ae2eff07e5"],["img/icons/icon-144x144.png","a83cbec205133cc66a534f785038e28c"],["img/icons/icon-152x152.png","3de28e148a5d390baf047f4f4b5e5fcd"],["img/icons/icon-192x192.png","b297651f31257a3bfafc55eb85979eab"],["img/icons/icon-384x384.png","2577e718815d288aa843f46899f4a258"],["img/icons/icon-512x512.png","d4b3a42892196848ec04e3e9590c007b"],["img/icons/icon-72x72.png","87b776dbc7c9b560e416e1d60167df9f"],["img/icons/icon-96x96.png","c23af9099da24b8f5348785aaf03b225"],["img/lanparty2.jpg","271f1961c3fd3f6a59d6246fa5b6097b"],["img/logo.png","30678827acfbed595f50735f6eebb1e8"],["img/logo512x512.png","57102b6df5cb71bcdcf0355b87ed1d7d"],["img/logos/AGI.jpg","1e15167a1d69c95ad1ecf988ac6ef87c"],["img/logos/Ajuntament.jpg","0f015f584e56d1b074bdf81f78e02c5e"],["img/logos/Almendros.jpg","aa7f5c0dd5fd19348e2a42c4c8e722a0"],["img/logos/Alonso.jpg","523fd0708e386b25257d0eb14579817d"],["img/logos/Altercom.jpg","4f4384d24b2c6b7fb6e077a825235614"],["img/logos/BEEP.jpg","aec43935e844fde61ecfccb62d675b22"],["img/logos/Disi.jpg","cfcfd753bc74638b2106746a686c055d"],["img/logos/FerreteriaGarcia.png","f55b9a0c877f5218f3aacfd10df49dde"],["img/logos/Globals.jpg","417ef70e9816502e085a96c1111c2336"],["img/logos/Guerra.jpg","cd7b2fb764bf01017d7e04a2b41fa78d"],["img/logos/Jabil.jpg","22a31554cdeab95be273509c27aeba22"],["img/logos/PcServeis.jpg","29e1fc338922d4b1f1b072b8154a0f0b"],["img/logos/Querol.jpg","1c24a6dccd257cbcebbfd3424c82e4f3"],["img/logos/RecyclingSystem.jpg","1401a04caeaf53428dd2f4ad275ebaf2"],["img/logos/SecurityPla.jpg","ae2ddaa6adf98d7957c5f712bbb1ab8d"],["img/logos/TheWorkShop.jpg","f8d3110a819ec4d036ee45eba8a371e4"],["img/logos/Tomas.jpg","bd7c4926585cad616beb9b7e84e13bba"],["img/logos/defaultAvatarPartner/defaultPartner.png","34f1087cc355319c97e28bb4d14965db"],["img/logos/ePorts.jpg","429c73c46c879fad80fef6ef45cfeaa5"],["img/logos/iesEbre.jpg","5c0ab2e9ec4b93d7fab4a942b4b39a9b"],["img/overwatch-logo-hd-png.png","3ab9b9eed0cf97b1d8dae5195ecff5a4"],["img/programacio.png","b9f31e2969ab6d438546a923eb9ca526"],["img/red.png","1bc8311e97b800a409de6d4e915749b1"],["img/user2-bg.jpg","5ca6669d1303dbe3fa597a7c1bd33e67"],["js/odometer.min.js","137173424eea612b37a46854e4884fc1"],["js/push_message.js","067fd39611b0af50648468cd20e87e24"],["service-worker.js","207620e5f297d8c23c48649f75ae37f6"],["svg/403.svg","93d6475bd2581cb5aa1b527aa8152a95"],["svg/404.svg","ea2bc467605d3d3aa715c6a3655a4e42"],["svg/500.svg","f56a358742db1d15fc06934278e59703"],["svg/503.svg","bb681f2ad0a2a75161eea851ff83b4e2"]];
var cacheName = 'sw-precache-v3-lanparty-' + (self.registration ? self.registration.scope : '');


var ignoreUrlParametersMatching = [/^utm_/];



var addDirectoryIndex = function(originalUrl, index) {
    var url = new URL(originalUrl);
    if (url.pathname.slice(-1) === '/') {
      url.pathname += index;
    }
    return url.toString();
  };

var cleanResponse = function(originalResponse) {
    // If this is not a redirected response, then we don't have to do anything.
    if (!originalResponse.redirected) {
      return Promise.resolve(originalResponse);
    }

    // Firefox 50 and below doesn't support the Response.body stream, so we may
    // need to read the entire body to memory as a Blob.
    var bodyPromise = 'body' in originalResponse ?
      Promise.resolve(originalResponse.body) :
      originalResponse.blob();

    return bodyPromise.then(function(body) {
      // new Response() is happy when passed either a stream or a Blob.
      return new Response(body, {
        headers: originalResponse.headers,
        status: originalResponse.status,
        statusText: originalResponse.statusText
      });
    });
  };

var createCacheKey = function(originalUrl, paramName, paramValue,
                           dontCacheBustUrlsMatching) {
    // Create a new URL object to avoid modifying originalUrl.
    var url = new URL(originalUrl);

    // If dontCacheBustUrlsMatching is not set, or if we don't have a match,
    // then add in the extra cache-busting URL parameter.
    if (!dontCacheBustUrlsMatching ||
        !(url.pathname.match(dontCacheBustUrlsMatching))) {
      url.search += (url.search ? '&' : '') +
        encodeURIComponent(paramName) + '=' + encodeURIComponent(paramValue);
    }

    return url.toString();
  };

var isPathWhitelisted = function(whitelist, absoluteUrlString) {
    // If the whitelist is empty, then consider all URLs to be whitelisted.
    if (whitelist.length === 0) {
      return true;
    }

    // Otherwise compare each path regex to the path of the URL passed in.
    var path = (new URL(absoluteUrlString)).pathname;
    return whitelist.some(function(whitelistedPathRegex) {
      return path.match(whitelistedPathRegex);
    });
  };

var stripIgnoredUrlParameters = function(originalUrl,
    ignoreUrlParametersMatching) {
    var url = new URL(originalUrl);
    // Remove the hash; see https://github.com/GoogleChrome/sw-precache/issues/290
    url.hash = '';

    url.search = url.search.slice(1) // Exclude initial '?'
      .split('&') // Split into an array of 'key=value' strings
      .map(function(kv) {
        return kv.split('='); // Split each 'key=value' string into a [key, value] array
      })
      .filter(function(kv) {
        return ignoreUrlParametersMatching.every(function(ignoredRegex) {
          return !ignoredRegex.test(kv[0]); // Return true iff the key doesn't match any of the regexes.
        });
      })
      .map(function(kv) {
        return kv.join('='); // Join each [key, value] array into a 'key=value' string
      })
      .join('&'); // Join the array of 'key=value' strings into a string with '&' in between each

    return url.toString();
  };


var hashParamName = '_sw-precache';
var urlsToCacheKeys = new Map(
  precacheConfig.map(function(item) {
    var relativeUrl = item[0];
    var hash = item[1];
    var absoluteUrl = new URL(relativeUrl, self.location);
    var cacheKey = createCacheKey(absoluteUrl, hashParamName, hash, false);
    return [absoluteUrl.toString(), cacheKey];
  })
);

function setOfCachedUrls(cache) {
  return cache.keys().then(function(requests) {
    return requests.map(function(request) {
      return request.url;
    });
  }).then(function(urls) {
    return new Set(urls);
  });
}

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return setOfCachedUrls(cache).then(function(cachedUrls) {
        return Promise.all(
          Array.from(urlsToCacheKeys.values()).map(function(cacheKey) {
            // If we don't have a key matching url in the cache already, add it.
            if (!cachedUrls.has(cacheKey)) {
              var request = new Request(cacheKey, {credentials: 'same-origin'});
              return fetch(request).then(function(response) {
                // Bail out of installation unless we get back a 200 OK for
                // every request.
                if (!response.ok) {
                  throw new Error('Request for ' + cacheKey + ' returned a ' +
                    'response with status ' + response.status);
                }

                return cleanResponse(response).then(function(responseToCache) {
                  return cache.put(cacheKey, responseToCache);
                });
              });
            }
          })
        );
      });
    }).then(function() {
      
      // Force the SW to transition from installing -> active state
      return self.skipWaiting();
      
    })
  );
});

self.addEventListener('activate', function(event) {
  var setOfExpectedUrls = new Set(urlsToCacheKeys.values());

  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.keys().then(function(existingRequests) {
        return Promise.all(
          existingRequests.map(function(existingRequest) {
            if (!setOfExpectedUrls.has(existingRequest.url)) {
              return cache.delete(existingRequest);
            }
          })
        );
      });
    }).then(function() {
      
      return self.clients.claim();
      
    })
  );
});


self.addEventListener('fetch', function(event) {
  if (event.request.method === 'GET') {
    // Should we call event.respondWith() inside this fetch event handler?
    // This needs to be determined synchronously, which will give other fetch
    // handlers a chance to handle the request if need be.
    var shouldRespond;

    // First, remove all the ignored parameters and hash fragment, and see if we
    // have that URL in our cache. If so, great! shouldRespond will be true.
    var url = stripIgnoredUrlParameters(event.request.url, ignoreUrlParametersMatching);
    shouldRespond = urlsToCacheKeys.has(url);

    // If shouldRespond is false, check again, this time with 'index.html'
    // (or whatever the directoryIndex option is set to) at the end.
    var directoryIndex = 'index.html';
    if (!shouldRespond && directoryIndex) {
      url = addDirectoryIndex(url, directoryIndex);
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond is still false, check to see if this is a navigation
    // request, and if so, whether the URL matches navigateFallbackWhitelist.
    var navigateFallback = '';
    if (!shouldRespond &&
        navigateFallback &&
        (event.request.mode === 'navigate') &&
        isPathWhitelisted([], event.request.url)) {
      url = new URL(navigateFallback, self.location).toString();
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond was set to true at any point, then call
    // event.respondWith(), using the appropriate cache key.
    if (shouldRespond) {
      event.respondWith(
        caches.open(cacheName).then(function(cache) {
          return cache.match(urlsToCacheKeys.get(url)).then(function(response) {
            if (response) {
              return response;
            }
            throw Error('The cached response that was expected is missing.');
          });
        }).catch(function(e) {
          // Fall back to just fetch()ing the request if some unexpected error
          // prevented the cached response from being valid.
          console.warn('Couldn\'t serve response for "%s" from cache: %O', event.request.url, e);
          return fetch(event.request);
        })
      );
    }
  }
});







importScripts("/js/push_message.js");

