WebP Express 0.19.0. Conversion triggered using bulk conversion, 2021-04-08 12:30:55

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.3.27
- Server software: nginx/1.18.0

Stack converter ignited

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg
- destination: [doc-root]/app/webp-express/webp-images/doc-root/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg.webp
- log-call-arguments: true
- converters: (array of 10 items)

The following options have not been explicitly set, so using the following defaults:
- converter-options: (empty array)
- shuffle: false
- preferred-converters: (empty array)
- extra-converters: (empty array)

The following options were supplied and are passed on to the converters in the stack:
- default-quality: 70
- encoding: "auto"
- max-quality: 80
- metadata: "none"
- near-lossless: 60
- quality: "auto"
------------


*Trying: cwebp* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg
- destination: [doc-root]/app/webp-express/webp-images/doc-root/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg.webp
- default-quality: 70
- encoding: "auto"
- low-memory: true
- log-call-arguments: true
- max-quality: 80
- metadata: "none"
- method: 6
- near-lossless: 60
- quality: "auto"
- use-nice: true
- command-line-options: ""
- try-common-system-paths: true
- try-supplied-binary-for-os: true

The following options have not been explicitly set, so using the following defaults:
- alpha-quality: 85
- auto-filter: false
- preset: "none"
- size-in-percentage: null (not set)
- skip: false
- rel-path-to-precompiled-binaries: *****
- try-cwebp: true
- try-discovering-cwebp: true
------------

Encoding is set to auto - converting to both lossless and lossy and selecting the smallest file

Converting to lossy
Looking for cwebp binaries.
Discovering if a plain cwebp call works (to skip this step, disable the "try-cwebp" option)
- Executing: cwebp -version 2>&1. Result: *Exec failed* (the cwebp binary was not found at path: cwebp, or it had missing library dependencies)
Nope a plain cwebp call does not work
Discovering binaries using "which -a cwebp" command. (to skip this step, disable the "try-discovering-cwebp" option)
Found 0 binaries
Discovering binaries by peeking in common system paths (to skip this step, disable the "try-common-system-paths" option)
Found 0 binaries
Discovering binaries which are distributed with the webp-convert library (to skip this step, disable the "try-supplied-binary-for-os" option)
Checking if we have a supplied precompiled binary for your OS (Linux)... We do. We in fact have 3
Found 3 binaries: 
- [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-linux-x86-64
- [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static
- [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64
Detecting versions of the cwebp binaries found
- Executing: [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-linux-x86-64 -version 2>&1. Result: *Exec failed*. Permission denied (user: "staging" does not have permission to execute that binary)
- Executing: [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static -version 2>&1. Result: *Exec failed*. Permission denied (user: "staging" does not have permission to execute that binary)
- Executing: [doc-root]/app/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64 -version 2>&1. Result: *Exec failed*. Permission denied (user: "staging" does not have permission to execute that binary)

**Error: ** **No cwebp binaries could be executed (permission denied for user: "staging").** 
No cwebp binaries could be executed (permission denied for user: "staging").
cwebp failed in 146 ms

*Trying: vips* 

**Error: ** **Required Vips extension is not available.** 
Required Vips extension is not available.
vips failed in 1 ms

*Trying: imagemagick* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg
- destination: [doc-root]/app/webp-express/webp-images/doc-root/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg.webp
- default-quality: 70
- encoding: "auto"
- log-call-arguments: true
- max-quality: 80
- metadata: "none"
- quality: "auto"
- use-nice: true

The following options have not been explicitly set, so using the following defaults:
- alpha-quality: 85
- auto-filter: false
- low-memory: false
- method: 6
- skip: false

The following options were supplied but are ignored because they are not supported by this converter:
- near-lossless
------------

Encoding is set to auto - converting to both lossless and lossy and selecting the smallest file

Converting to lossy
Version: ImageMagick 7.0.8-42 Q16 x86_64 2019-04-24 https://imagemagick.org
Quality of source is 92. This is higher than max-quality, so using max-quality instead (80)
using nice
Executing command: nice convert -quality '80' -strip -define webp:alpha-quality=85 -define webp:method=6 '[doc-root]/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg' 'webp:[doc-root]/app/webp-express/webp-images/doc-root/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg.webp.lossy.webp' 2>&1
success
Reduction: 33% (went from 3169 bytes to 2138 bytes)

Converting to lossless
Version: ImageMagick 7.0.8-42 Q16 x86_64 2019-04-24 https://imagemagick.org
using nice
Executing command: nice convert -quality '80' -define webp:lossless=true -strip -define webp:alpha-quality=85 -define webp:method=6 '[doc-root]/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg' 'webp:[doc-root]/app/webp-express/webp-images/doc-root/app/uploads/2021/02/pexels-basil-mk-247040-150x150.jpg.webp.lossless.webp' 2>&1
success
Reduction: -463% (went from 3169 bytes to 17842 bytes)

Picking lossy
imagemagick succeeded :)

Converted image in 617 ms, reducing file size with 33% (went from 3169 bytes to 2138 bytes)
