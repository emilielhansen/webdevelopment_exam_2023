-- Give partner an order
UPDATE orders
SET order_delivered_by_user_fk = 'db294b21d7fd190aa08ee7f9068afe19'
WHERE order_id = 'abd0d49d10ba306de2c0f595bb74a271';

-- Give user an order
UPDATE orders
SET order_created_by_user_fk = '8da42b78fd34407c8ca0aa35417889b2'
WHERE order_id = 'c30e221ff10e21018f2885838e8d2835';