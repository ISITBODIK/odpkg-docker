class Geo::PolygonDataBuilderService < ServiceBase

  def initialize(geojson, rows)
    @geojson = geojson
    @rows = rows
  end

  def perform

    header = @rows.shift
    loc_idx = header.index('町名') #町名の入ったカラムのインデクス

    # 集計に使用するカラムのインデクスを取得する
    count_idx = nil
    Settings.polygon.columns.each do |column|
      count_idx = header.index(column)
      break unless count_idx.nil?
    end

    # 集計カラム名が見つからない場合はエラー
    if count_idx.nil?
      message = '集計カラム不明エラー' % []
      raise ServiceError, message
    end

    loc_hash = {} #町名をキーとした値のリスト
    @rows.each do |row|
      loc_hash[row[loc_idx]] = row
    end

    # 最大値最小値の計算
    nums = @rows.collect{|row| row[count_idx].to_f}
    min = nums.min
    max = nums.max

    # 位置情報とデータを紐付ける
    @geojson[:features].each do |feature|
      loc_name = feature[:properties][:'__name']
      next if loc_name.nil?
      
      loc_data = loc_hash[loc_name]
      next if loc_data.nil?

      header.each_with_index do |field, idx|
        feature[:properties][field] = loc_data[idx].to_s
      end

      # 地図塗り分け用の値作成
      num = loc_data[count_idx].to_f
      range = (((num - min) / (max - min)) * 5.0).floor
      feature[:properties][:'__range'] = range

      # feature[:properties].delete(:'__name')
    end

    @geojson
  end

end
