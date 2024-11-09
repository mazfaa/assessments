"use strict";
const { Model } = require("sequelize");
module.exports = (sequelize, DataTypes) => {
  class Transaction extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
    }
  }
  Transaction.init(
    {
      invoiceNo: DataTypes.STRING,
      date: DataTypes.DATE,
    },
    {
      sequelize,
      modelName: "Transaction",
    }
  );
  Transaction.associate = (models) => {
    Transaction.belongsTo(models.Product, {
      foreignKey: "product_id",
      as: "product",
    });
    Transaction.belongsTo(models.User, {
      foreignKey: "user_id",
      as: "user",
    });
  };

  return Transaction;
};
