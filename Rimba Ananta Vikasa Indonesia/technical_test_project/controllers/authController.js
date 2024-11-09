const { User } = require("../models");
const bcrypt = require("bcrypt");
const { v4: uuidv4 } = require("uuid");
const jwt = require("jsonwebtoken");

exports.register = async (req, res) => {
  try {
    const { email, password, name, phoneNumber } = req.body;
    const hashedPassword = bcrypt.hashSync(password, 10);

    const user = await User.create({
      email,
      password: hashedPassword,
      name,
      phoneNumber,
    });

    res.json({
      requestId: uuidv4(),
      data: user,
      message: "Registration successful",
      success: true,
    });
  } catch (error) {
    res.status(500).json({
      requestId: uuidv4(),
      data: null,
      message: error.message,
      success: false,
    });
  }
};

exports.login = async (req, res) => {
  try {
    const { email, password } = req.body;
    const user = await User.findOne({ where: { email } });

    if (!user || !bcrypt.compareSync(password, user.password)) {
      return res.status(401).json({
        requestId: uuidv4(),
        data: null,
        message: "Invalid email or password",
        success: false,
      });
    }

    const accessToken = jwt.sign({ userId: user.id }, process.env.JWT_SECRET, {
      expiresIn: "1h",
    });
    const refreshToken = jwt.sign(
      { userId: user.id },
      process.env.JWT_REFRESH_SECRET
    );

    res.json({
      requestId: uuidv4(),
      data: {
        accessToken,
        refreshToken,
        expiredIn: 3600,
        user,
      },
      message: "Login successful",
      success: true,
    });
  } catch (error) {
    res.status(500).json({
      requestId: uuidv4(),
      data: null,
      message: error.message,
      success: false,
    });
  }
};