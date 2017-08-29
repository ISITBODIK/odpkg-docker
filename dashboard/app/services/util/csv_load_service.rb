class Util::CsvLoadService < ServiceBase
  require 'kconv'  

  def initialize(url, format)
    @url = url
    @format = format
  end

  def perform

    rows = [];
    uri = URI.parse(@url)

    file = Tempfile.new('dashboard')
    file.binmode
    begin

      begin
        res = Faraday.get(uri)
        raise ServiceError, res.message unless res.success?
        if 'CSV' == @format
          file << res.body.toutf8
        else
          file << res.body
        end
        file.rewind
      rescue => e
        message = 'CSVダウンロードエラー url:%s message:%s' % [@url, e.message]
        raise ServiceError, message
      end

      begin
        book = Roo::Spreadsheet.open(file, extension: @format)
        rows = book.to_a
      rescue => e
        message = 'CSV読込エラー url:%s message:%s' % [@url, e.message]
        raise ServiceError, message
      end

    ensure
      file.close
      file.unlink
    end

    rows
  end
  
end