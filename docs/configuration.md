# Full configuration options

```yaml
# Symfony 3: app/config/config.yml
# Symfony 4: config/packages/tworks_ck_editor_sonata_media.yaml

tworks_ck_editor_sonata_media:
    templates:
        layout: TWorksCKEditorSonataMediaBundlefork::layout.html.twig # Layout of the file browser
        browser: TWorksCKEditorSonataMediaBundlefork:MediaAdmin:browser.html.twig # Template of the CKEditor file browser
        upload: TWorksCKEditorSonataMediaBundlefork:MediaAdmin:upload.html.twig # Template returned after a direct upload
```
