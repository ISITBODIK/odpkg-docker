class ServiceBase

  def logger
    Rails.logger
  end

  def call
    begin
      perform
    rescue => e
      logger.error 'ServiceError %s %s' % [self.class, e.message]
      raise e
    end
  end

  def perform
    raise NotImplementedError
  end

end
