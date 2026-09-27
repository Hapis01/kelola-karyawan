import 'package:intl/intl.dart';

class DateTimeUtils {
  static String formatDate(DateTime date, {String format = 'dd/MM/yyyy'}) {
    return DateFormat(format).format(date);
  }

  static String formatDateTime(DateTime dateTime, {String format = 'dd/MM/yyyy HH:mm'}) {
    return DateFormat(format).format(dateTime);
  }

  static String formatTime(DateTime time, {String format = 'HH:mm'}) {
    return DateFormat(format).format(time);
  }

  static String formatDateShort(DateTime date) {
    return DateFormat('dd MMM yyyy').format(date);
  }

  static String formatDateLong(DateTime date) {
    return DateFormat('EEEE, dd MMMM yyyy').format(date);
  }

  static int daysBetween(DateTime from, DateTime to) {
    return to.difference(from).inDays;
  }

  static bool isToday(DateTime date) {
    final now = DateTime.now();
    return date.year == now.year && date.month == now.month && date.day == now.day;
  }

  static bool isYesterday(DateTime date) {
    final yesterday = DateTime.now().subtract(const Duration(days: 1));
    return date.year == yesterday.year && date.month == yesterday.month && date.day == yesterday.day;
  }

  static String timeAgo(DateTime dateTime) {
    final now = DateTime.now();
    final difference = now.difference(dateTime);

    if (difference.inDays > 365) {
      return '${(difference.inDays / 365).floor()} year${(difference.inDays / 365).floor() > 1 ? 's' : ''} ago';
    } else if (difference.inDays > 30) {
      return '${(difference.inDays / 30).floor()} month${(difference.inDays / 30).floor() > 1 ? 's' : ''} ago';
    } else if (difference.inDays > 0) {
      return '${difference.inDays} day${difference.inDays > 1 ? 's' : ''} ago';
    } else if (difference.inHours > 0) {
      return '${difference.inHours} hour${difference.inHours > 1 ? 's' : ''} ago';
    } else if (difference.inMinutes > 0) {
      return '${difference.inMinutes} minute${difference.inMinutes > 1 ? 's' : ''} ago';
    } else {
      return 'just now';
    }
  }
}

class StringUtils {
  static String capitalize(String text) {
    return text.isEmpty ? text : text[0].toUpperCase() + text.substring(1);
  }

  static String capitalizeEachWord(String text) {
    return text.split(' ').map((word) => capitalize(word)).join(' ');
  }

  static bool isEmailValid(String email) {
    const pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$';
    final regExp = RegExp(pattern);
    return regExp.hasMatch(email);
  }

  static bool isPhoneValid(String phone) {
    const pattern = r'^[\d\s\-\+\(\)]{10,}$';
    final regExp = RegExp(pattern);
    return regExp.hasMatch(phone);
  }

  static bool isPasswordStrong(String password) {
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
    const pattern = r'^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$';
    final regExp = RegExp(pattern);
    return regExp.hasMatch(password);
  }

  static String maskEmail(String email) {
    final parts = email.split('@');
    if (parts.length != 2) return email;

    final localPart = parts[0];
    final domain = parts[1];

    if (localPart.length <= 2) {
      return '${localPart[0]}***@$domain';
    }

    return '${localPart[0]}${'*' * (localPart.length - 2)}${localPart[localPart.length - 1]}@$domain';
  }

  static String truncate(String text, int length) {
    return text.length > length ? '${text.substring(0, length)}...' : text;
  }
}

class NumUtils {
  static String formatCurrency(double value, {String symbol = 'Rp. '}) {
    final formatter = NumberFormat('#,##0.00', 'id_ID');
    return '$symbol${formatter.format(value)}';
  }

  static String formatNumber(double value) {
    final formatter = NumberFormat('#,##0.##', 'id_ID');
    return formatter.format(value);
  }

  static String formatPercentage(double value) {
    return '${(value * 100).toStringAsFixed(2)}%';
  }
}
