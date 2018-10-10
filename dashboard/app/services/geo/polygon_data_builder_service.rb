# -*- coding: utf-8 -*-
class Geo::PolygonDataBuilderService < ServiceBase

  def initialize(geojson, rows)
    @geojson = geojson
    @rows = rows
    @rows_s = []
  end

  def perform

    header = @rows.shift

    loc_idx = nil
    loc_idx = header.index('KEY_CODE') # KEY_CODEの入ったカラムのインデクス

    if loc_idx.nil?
      loc_idx = 0
    end

    # 集計に使用するカラムのインデクスを取得する
    count_idx = nil
    Settings.polygon.columns.each do |column|
      count_idx = header.index(column)
      break unless count_idx.nil?
    end

    # 集計カラム名が見つからない場合はエラー
    if count_idx.nil?
      # message = '集計カラム不明エラー' % []
      # raise ServiceError, message
      count_idx = 1
    end

    ################################
    # 2017.06.01 nyoshimatsu
    ################################

    # check KEY_CODE. count number of area with a KEY_CODE.
    l   = []
    h   = []
    c   = []
    i   = -1
    idx = loc_idx
    @rows.each do |l|
      i   += 1
      c[i] = 1
  
      l[idx] = l[idx].to_s

      if    l[idx].length == 9 then
        c[i] = 0
        @rows.each do |h|

          h[idx] = h[idx].to_s

          if l[idx] == h[idx].slice(0,9) then
            c[i] += 1
          end
        end
      elsif l[idx].length == 5 then
        c[i] = 0
        @rows.each do |h|

          h[idx] = h[idx].to_s

          if l[idx] == h[idx].slice(0,5) then
            c[i] += 1
          end
        end
      end
    end

    # generate a new area info into a array (s[]).
    # there are single KEY_CODE area in the new area info.
    # (no overlap area with regard to KEY_CODE)

    i = -1
    j = -1
    @rows.each do |l|
      i += 1
      if c[i] <= 1 then
        j         += 1
        @rows_s[j] = l
      end
    end

    #####

    loc_hash = {} # KEY_CODEをキーとした値のリスト
    @rows_s.each do |row|
      loc_hash[row[loc_idx]] = row
    end

    # 最大値最小値の計算
    nums = @rows_s.collect{|row| row[count_idx].to_f}
    min = nums.min
    max = nums.max

    # 位置情報とデータを紐付ける
    @geojson[:features].each do |feature|
      loc_name = feature[:properties][:'KEY_CODE']
      next if loc_name.nil?
      
      loc_data = loc_hash[loc_name]

      next if loc_data.nil?

      header.each_with_index do |field, idx|
        
        #ピンデータはKEY_CODE以外の列は表示する Y.Sakamoto 2017.08.24
        if field != 'KEY_CODE' then
            feature[:properties][field] = loc_data[idx].to_s
        end 
 
      end

      # 地図塗り分け用の値作成
      num = loc_data[count_idx].to_f

      if max != min then
        range = (((num - min) / (max - min)) * 5.0).floor
      else
        range = 0
      end

      feature[:properties][:'__range'] = range
      
      # MOJI,KEY_CODE,KENIKI_NAMを追加 Y.Sakamoto 2017.08.24
      # feature[:properties].delete(:'__name')
      feature[:properties].delete(:'KEY_CODE')
      feature[:properties].delete(:'KEN_NAME')
      feature[:properties].delete(:'GST_NAME')
      feature[:properties].delete(:'CSS_NAME')
      feature[:properties].delete(:'MOJI')
      feature[:properties].delete(:'KENIKI_NAM')
    end

    @geojson
  end

end
