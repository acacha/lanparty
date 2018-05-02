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

var precacheConfig = [["/","27ccbd25e0797fe298c78242e432d8a2"],["/home","fdea42ff49a556128a2c7a5d771bc8d3"],["css/app.css","5b3d3bb7d4459a3030314f47533798c7"],["favicon.ico","d41d8cd98f00b204e9800998ecf8427e"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.eot","f4769f9bdb7466be65088239c12046d1"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.svg","89889688147bd7575d6327160d64e760"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.ttf","e18bbf611f2a2e43afc071aa2f4e1512"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.woff","fa2772327f55d8198301fdb8bcfc8158"],["fonts/vendor/bootstrap-sass/bootstrap/glyphicons-halflings-regular.woff2","448c34a56d699c29117adc64c43affeb"],["img/404.jpg","e82153cdee24c0f31c86b0d5b8937c8b"],["img/AgeOfEmpires2.png","490a281628fe571b231ab6d74e740e7e"],["img/CounterStrike.jpeg","70303b8c8afbb38982c81278e6c8340d"],["img/CounterStrike.png","18ebe1833089f7fd6e34478d313f46b0"],["img/FIFA18.png","ecf523aa11770d2a69225eb32f9ab61a"],["img/Fifa18.jpeg","5b46f3ecab1a07f58052050a20dd928b"],["img/Lanparty.jpg","4af97fd59b78093859a20fd739537cdc"],["img/Lanparty3.jpg","786bd0992ce2859e6c2e459df0c9df86"],["img/Lanparty4.jpg","0e3b2a5bf6792ce3345b40e9f1b789dd"],["img/LanpartyLanding.jpg","db2d83476e5ccf82d2fa48e225b3154c"],["img/LanpartyLanding2.jpg","5cf0c5d0d04dcc691f7d291efa57734c"],["img/LeagueofLegends.png","6ca8a97ae855a25e8abf4d67f88a8754"],["img/LoL.jpeg","24647659d4920584b96a358f9cc4313a"],["img/LoL.png","8729b68babaa2b8dd72d6cc5bdf59c9a"],["img/Overwatch.jpeg","1811cfcd68ba3ca1260e0b8054a40b3e"],["img/cartell LAN Party 2017 2.jpg","2f04bb380a89e2546b43c7affaffa5e0"],["img/cartellLANParty2017.jpg","2f04bb380a89e2546b43c7affaffa5e0"],["img/cartellLandingPage.jpg","96db8d9b816abcb064ddfd20d01299fb"],["img/group1.jpg","64e8d8acf6c892c4a1b071aeff6ea1d3"],["img/group2.jpg","a19f7f04eeb50add76b9d4cc6f4b34eb"],["img/group3.jpg","066de0298c4f5871cd7c5fd7c30fd549"],["img/group4.jpg","7127b06dbc9c0dc9655c14888e5f5da6"],["img/group5.jpg","97d11b05467753f7568d9bf8d6bb3233"],["img/groupPlaceholder.jpg","cc107bc4a8a640d4cb48d639b11e1709"],["img/hero.jpeg","ffec432016d09b9ac44d9bd71e620611"],["img/icons/icon-128x128.png","075f048017ddfb53b15aa1ae2eff07e5"],["img/icons/icon-144x144.png","a83cbec205133cc66a534f785038e28c"],["img/icons/icon-152x152.png","3de28e148a5d390baf047f4f4b5e5fcd"],["img/icons/icon-192x192.png","b297651f31257a3bfafc55eb85979eab"],["img/icons/icon-384x384.png","2577e718815d288aa843f46899f4a258"],["img/icons/icon-512x512.png","d4b3a42892196848ec04e3e9590c007b"],["img/icons/icon-72x72.png","87b776dbc7c9b560e416e1d60167df9f"],["img/icons/icon-96x96.png","c23af9099da24b8f5348785aaf03b225"],["img/lanparty2.jpg","271f1961c3fd3f6a59d6246fa5b6097b"],["img/logo.png","30678827acfbed595f50735f6eebb1e8"],["img/logo512x512.png","57102b6df5cb71bcdcf0355b87ed1d7d"],["img/overwatch-logo-hd-png.png","3ab9b9eed0cf97b1d8dae5195ecff5a4"],["img/user2-bg.jpg","5ca6669d1303dbe3fa597a7c1bd33e67"],["js/app.js","89707dc3347638b2f57b6ed366886025"],["js/push_message.js","067fd39611b0af50648468cd20e87e24"],["service-worker.js","ba7f6d789e65ee3a0e4ede5140f9f63a"],["storage/groupPlaceholder.jpg","cc107bc4a8a640d4cb48d639b11e1709"]];
var cacheName = 'sw-precache-v3-lanparty-' + (self.registration ? self.registration.scope : '');


var ignoreUrlParametersMatching = [/^utm_/];



var addDirectoryIndex = function (originalUrl, index) {
    var url = new URL(originalUrl);
    if (url.pathname.slice(-1) === '/') {
      url.pathname += index;
    }
    return url.toString();
  };

var cleanResponse = function (originalResponse) {
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

var createCacheKey = function (originalUrl, paramName, paramValue,
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

var isPathWhitelisted = function (whitelist, absoluteUrlString) {
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

var stripIgnoredUrlParameters = function (originalUrl,
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

