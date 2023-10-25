;; -----------------------------------------------------------------------------
;; gimp/theme.scm
;; -----------------------------------------------------------------------------


;; Source image files
;; ------------------

(define originalLogoImage (car (gimp-file-load
    RUN-NONINTERACTIVE
    "src/logo.png"
    ""
)))
;; blurred-logo.png is based on logo.png, which is the original image provided
;; by the FoBV, with a mediun blur applied with radius set to 1 and alpha
;; percentile set to 90 and all other settings left at their GIMP defaults.
(define blurredLogoImage (car (gimp-file-load
    RUN-NONINTERACTIVE
    "src/blurred-logo.png"
    ""
)))

;; Create outputs
;; --------------

;; Header Logo

(let*

    (
        (headerLogoImage (car (gimp-image-duplicate blurredLogoImage)))
        (headerLogoBackgroundLayer(car (gimp-layer-new
            headerLogoImage          ; image
            350                      ; width
            350                      ; height
            RGB-IMAGE                ; type
            "Background"             ; name
            100                      ; opacity
            LAYER-MODE-NORMAL-LEGACY ; mode 
        )))
    )

    (gimp-item-set-name
        (car (gimp-image-get-active-layer headerLogoImage)) ; item
        "Logo"                                              ; name
    )

    (gimp-context-set-background '(180.0 202.0 125.0))

    (gimp-drawable-fill
        headerLogoBackgroundLayer ; drawable
        FILL-BACKGROUND           ; fill-type
    )

    (gimp-image-insert-layer headerLogoImage
        headerLogoBackgroundLayer ; layer
        0                         ; parent (main layer stack)
        1                         ; position (behind the headerLogoLayer)
    )

    (gimp-image-scale headerLogoImage 150 150)

    (file-webp-save
        RUN-NONINTERACTIVE      ; Interactive, non-interactive
        headerLogoImage         ; Input image
        (car (gimp-image-merge-visible-layers
            headerLogoImage     ; image
            CLIP-TO-IMAGE       ; merge-type
        ))                      ; Drawable to save
        "dist/header-logo.webp" ; The name of the file to save the image to
        "dist/header-logo.webp" ; The name entered
        0                       ; preset
        1                       ; Use lossless encoding
        90                      ; Quality of the image
        100                     ; Quality of the image's alpha channel
        0                       ; Use layers for animation
        0                       ; Loop animation infinitely
        0                       ; Minimize animation size
        0                       ; Maximum distance between key-frames
        0                       ; Toggle saving exif data
        0                       ; Toggle saving iptc data
        0                       ; Toggle saving xmp data
        0                       ; Delay
        0                       ; Force delay on all frames
    )

    (gimp-image-delete headerLogoImage)

)

;; Footer Logo

(let*

    (
        (footerLogoImage (car (gimp-image-duplicate originalLogoImage)))
        (footerLogoDrawable (car (gimp-image-get-active-layer footerLogoImage)))
        (footerLogoBackgroundLayer(car (gimp-layer-new
            footerLogoImage          ; image
            350                      ; width
            350                      ; height
            RGB-IMAGE                ; type
            "Background"             ; name
            100                      ; opacity
            LAYER-MODE-NORMAL-LEGACY ; mode 
        )))
    )

    (gimp-item-set-name
        (car (gimp-image-get-active-layer footerLogoImage)) ; item
        "Logo"                                              ; name
    )

    (gimp-context-set-background '(82.0 128.0 52.0))

    (gimp-drawable-fill
        footerLogoBackgroundLayer ; drawable
        FILL-BACKGROUND           ; fill-type
    )

    (gimp-image-insert-layer footerLogoImage
        footerLogoBackgroundLayer ; layer
        0                         ; parent (main layer stack)
        1                         ; position (behind the headerLogoLayer)
    )

    (gimp-drawable-invert footerLogoDrawable TRUE)
    (gimp-image-scale footerLogoImage 150 150)

    (file-webp-save
        RUN-NONINTERACTIVE      ; Interactive, non-interactive
        footerLogoImage         ; Input image
        (car (gimp-image-merge-visible-layers
            footerLogoImage     ; image
            CLIP-TO-IMAGE       ; merge-type
        ))                      ; Drawable to save
        "dist/footer-logo.webp" ; The name of the file to save the image to
        "dist/footer-logo.webp" ; The name entered
        0                       ; preset
        0                       ; Use lossless encoding
        90                      ; Quality of the image
        100                     ; Quality of the image's alpha channel
        0                       ; Use layers for animation
        0                       ; Loop animation infinitely
        0                       ; Minimize animation size
        0                       ; Maximum distance between key-frames
        0                       ; Toggle saving exif data
        0                       ; Toggle saving iptc data
        0                       ; Toggle saving xmp data
        0                       ; Delay
        0                       ; Force delay on all frames
    )

    (gimp-image-delete footerLogoImage)

)

;; Viaduct Panorama 1

(let*

    (
        (viaductPanorama1Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-1.png" ""
        )))                
        (viaductPanorama1Drawable (car (gimp-image-get-active-layer
            viaductPanorama1Image
        )))
    )

    (gimp-image-scale viaductPanorama1Image 1920 1080)
    (gimp-image-crop viaductPanorama1Image 1920 600 0 265)
    (gimp-drawable-brightness-contrast viaductPanorama1Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama1Image          ; Input image
        viaductPanorama1Drawable       ; Drawable to save
        "dist/viaduct-panorama-1.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama1Image)

)

;; Viaduct Panorama 2

(let*

    (
        (viaductPanorama2Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-2.png" ""
        )))                
        (viaductPanorama2Drawable (car (gimp-image-get-active-layer
            viaductPanorama2Image
        )))
    )

    (gimp-image-scale viaductPanorama2Image 1920 815)
    (gimp-image-crop viaductPanorama2Image 1920 600 0 100)
    (gimp-drawable-brightness-contrast viaductPanorama2Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama2Image          ; Input image
        viaductPanorama2Drawable       ; Drawable to save
        "dist/viaduct-panorama-2.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama2Image)

)

;; Viaduct Panorama 3

(let*

    (
        (viaductPanorama3Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-3.png" ""
        )))                
        (viaductPanorama3Drawable (car (gimp-image-get-active-layer
            viaductPanorama3Image
        )))
    )

    (gimp-image-crop viaductPanorama3Image 1920 600 128 110)
    (gimp-drawable-brightness-contrast viaductPanorama3Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama3Image          ; Input image
        viaductPanorama3Drawable       ; Drawable to save
        "dist/viaduct-panorama-3.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama3Image)

)

;; Viaduct Panorama 4

(let*

    (
        (viaductPanorama4Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-4.png" ""
        )))                
        (viaductPanorama4Drawable (car (gimp-image-get-active-layer
            viaductPanorama4Image
        )))
    )

    (gimp-image-scale viaductPanorama4Image 1920 1280)
    (gimp-image-crop viaductPanorama4Image 1920 600 0 550)
    (gimp-drawable-brightness-contrast viaductPanorama4Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama4Image          ; Input image
        viaductPanorama4Drawable       ; Drawable to save
        "dist/viaduct-panorama-4.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama4Image)

)

;; Viaduct Panorama 5

(let*

    (
        (viaductPanorama5Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-5.png" ""
        )))                
        (viaductPanorama5Drawable (car (gimp-image-get-active-layer
            viaductPanorama5Image
        )))
    )

    (gimp-image-crop viaductPanorama5Image 1920 600 128 200)
    (gimp-drawable-brightness-contrast viaductPanorama5Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama5Image          ; Input image
        viaductPanorama5Drawable       ; Drawable to save
        "dist/viaduct-panorama-5.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama5Image)

)

;; Viaduct Panorama 6

(let*

    (
        (viaductPanorama6Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-6.png" ""
        )))                
        (viaductPanorama6Drawable (car (gimp-image-get-active-layer
            viaductPanorama6Image
        )))
    )

    (gimp-image-scale viaductPanorama6Image 1920 1279)
    (gimp-image-crop viaductPanorama6Image 1920 600 0 360)
    (gimp-drawable-brightness-contrast viaductPanorama6Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama6Image          ; Input image
        viaductPanorama6Drawable       ; Drawable to save
        "dist/viaduct-panorama-6.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama6Image)

)

;; Viaduct Panorama 7

(let*

    (
        (viaductPanorama7Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-7.png" ""
        )))                
        (viaductPanorama7Drawable (car (gimp-image-get-active-layer
            viaductPanorama7Image
        )))
    )

    (gimp-image-crop viaductPanorama7Image 1920 600 128 200)
    (gimp-drawable-brightness-contrast viaductPanorama7Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama7Image          ; Input image
        viaductPanorama7Drawable       ; Drawable to save
        "dist/viaduct-panorama-7.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama7Image)

)

;; Viaduct Panorama 8

(let*

    (
        (viaductPanorama8Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-8.png" ""
        )))                
        (viaductPanorama8Drawable (car (gimp-image-get-active-layer
            viaductPanorama8Image
        )))
    )

    (gimp-image-crop viaductPanorama8Image 1920 600 128 175)
    (gimp-drawable-brightness-contrast viaductPanorama8Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama8Image          ; Input image
        viaductPanorama8Drawable       ; Drawable to save
        "dist/viaduct-panorama-8.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama8Image)

)

;; Viaduct Panorama 9

(let*

    (
        (viaductPanorama9Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-9.png" ""
        )))                
        (viaductPanorama9Drawable (car (gimp-image-get-active-layer
            viaductPanorama9Image
        )))
    )

    (gimp-image-crop viaductPanorama9Image 1920 600 0 315)
    (gimp-drawable-brightness-contrast viaductPanorama9Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE             ; Interactive, non-interactive
        viaductPanorama9Image          ; Input image
        viaductPanorama9Drawable       ; Drawable to save
        "dist/viaduct-panorama-9.webp" ; Name of the file to save the image to
        ""                             ; Name entered
        0                              ; preset
        0                              ; Use lossless encoding
        90                             ; Quality of the image
        100                            ; Quality of the image's alpha channel
        0                              ; Use layers for animation
        0                              ; Loop animation infinitely
        0                              ; Minimize animation size
        0                              ; Maximum distance between key-frames
        0                              ; Toggle saving exif data
        0                              ; Toggle saving iptc data
        0                              ; Toggle saving xmp data
        0                              ; Delay
        0                              ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama9Image)

)

;; Viaduct Panorama 10

(let*

    (
        (viaductPanorama10Image (car (gimp-file-load
            RUN-NONINTERACTIVE "src/viaduct-panorama-10.png" ""
        )))                
        (viaductPanorama10Drawable (car (gimp-image-get-active-layer
            viaductPanorama10Image
        )))
    )

    (gimp-image-crop viaductPanorama10Image 1920 600 0 460)
    (gimp-drawable-brightness-contrast viaductPanorama10Drawable 0.5 0)

    (file-webp-save
        RUN-NONINTERACTIVE              ; Interactive, non-interactive
        viaductPanorama10Image          ; Input image
        viaductPanorama10Drawable       ; Drawable to save
        "dist/viaduct-panorama-10.webp" ; Name of the file to save the image to
        ""                              ; Name entered
        0                               ; preset
        0                               ; Use lossless encoding
        90                              ; Quality of the image
        100                             ; Quality of the image's alpha channel
        0                               ; Use layers for animation
        0                               ; Loop animation infinitely
        0                               ; Minimize animation size
        0                               ; Maximum distance between key-frames
        0                               ; Toggle saving exif data
        0                               ; Toggle saving iptc data
        0                               ; Toggle saving xmp data
        0                               ; Delay
        0                               ; Force delay on all frames
    )

    (gimp-image-delete viaductPanorama10Image)

)

(gimp-image-delete originalLogoImage)
(gimp-image-delete blurredLogoImage)
(gimp-quit 0)
