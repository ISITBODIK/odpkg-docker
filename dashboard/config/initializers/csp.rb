SecureHeaders::Configuration.default do |config|
  config.csp = {
    default_src: %w('self'),
    script_src: %w('self' 'unsafe-inline' 'unsafe-eval' https://maps.googleapis.com https://www.google-analytics.com),
    style_src: %w('self' 'unsafe-inline' https://fonts.googleapis.com),
    img_src: %w('self' https://maps.googleapis.com https://maps.gstatic.com https://csi.gstatic.com https://www.google-analytics.com),
    font_src: %w('self' https://fonts.gstatic.com)
  }
end
